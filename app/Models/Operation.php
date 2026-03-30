<?php
// app/Models/Operation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    use HasFactory;

    protected $table = 'operations';
    protected $primaryKey = 'id_operation';

    protected $fillable = [
        'type_operation',
        'montant',
        'date_operation',
        'libelle',
        'id_compte',
        'id_compte_dest'
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'date_operation' => 'datetime'
    ];

    public function compte()
    {
        return $this->belongsTo(Compte::class, 'id_compte');
    }

    public function compteDestinataire()
    {
        return $this->belongsTo(Compte::class, 'id_compte_dest');
    }

   public function getMontantFormateAttribute()
{
    return number_format($this->montant, 2, ',', ' ') . ' DH';
}
    public function getTypeOperationLibelleAttribute()
    {
        $types = [
            'depot' => 'Dépôt',
            'retrait' => 'Retrait',
            'virement' => 'Virement',
            'prelevement' => 'Prélèvement',
            'frais' => 'Frais bancaires'
        ];
        
        return $types[$this->type_operation] ?? $this->type_operation;
    }

    public function scopeDuMois($query)
    {
        return $query->whereMonth('date_operation', now()->month)
                     ->whereYear('date_operation', now()->year);
    }

    public function scopeParType($query, $type)
    {
        return $query->where('type_operation', $type);
    }

    public function scopeEntreDates($query, $debut, $fin)
    {
        return $query->whereBetween('date_operation', [$debut, $fin]);
    }
}
