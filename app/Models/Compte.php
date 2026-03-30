<?php
// app/Models/Compte.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compte extends Model
{
    use HasFactory;

    protected $table = 'comptes';
    protected $primaryKey = 'id_compte';

    protected $fillable = [
        'numero_compte',
        'type_compte',
        'solde',
        'date_ouverture',
        'statut',
        'id_client'
    ];

    protected $casts = [
        'solde' => 'decimal:2', // En MAD
        'date_ouverture' => 'date'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }

    public function operations()
    {
        return $this->hasMany(Operation::class, 'id_compte');
    }

    public function operationsDestinataires()
    {
        return $this->hasMany(Operation::class, 'id_compte_dest');
    }

    public function crediter($montant, $libelle = 'Crédit')
    {
        $this->solde += $montant;
        $this->save();

        return $this->operations()->create([
            'type_operation' => 'depot',
            'montant' => $montant,
            'libelle' => $libelle,
            'date_operation' => now()
        ]);
    }

    public function debiter($montant, $libelle = 'Débit')
    {
        if ($this->solde >= $montant) {
            $this->solde -= $montant;
            $this->save();

            return $this->operations()->create([
                'type_operation' => 'retrait',
                'montant' => $montant,
                'libelle' => $libelle,
                'date_operation' => now()
            ]);
        }
        
        return false;
    }

    public function transferer(Compte $compteDest, $montant, $libelle = 'Virement')
    {
        if ($this->debiter($montant, "Virement émis vers " . $compteDest->numero_compte)) {
            $compteDest->crediter($montant, "Virement reçu de " . $this->numero_compte);
            
            // Enregistrer l'opération de virement
            Operation::create([
                'type_operation' => 'virement',
                'montant' => $montant,
                'libelle' => $libelle,
                'date_operation' => now(),
                'id_compte' => $this->id_compte,
                'id_compte_dest' => $compteDest->id_compte
            ]);

            return true;
        }
        
        return false;
    }

   public function getSoldeFormateAttribute()
{
    return number_format($this->solde, 2, ',', ' ') . ' DH';
}
    public function scopeActifs($query)
    {
        return $query->where('statut', 'actif');
    }

    public function scopeParType($query, $type)
    {
        return $query->where('type_compte', $type);
    }
}