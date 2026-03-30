<?php
// app/Models/MoyenPaiement.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoyenPaiement extends Model
{
    use HasFactory;

    protected $table = 'moyens_paiement';
    protected $primaryKey = 'id_moyen';

    protected $fillable = [
        'type_moyen',
        'numero',
        'date_emission',
        'date_expiration',
        'statut',
        'id_client'
    ];

    protected $casts = [
        'date_emission' => 'date',
        'date_expiration' => 'date'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }

    public function estExpire()
    {
        return $this->date_expiration && $this->date_expiration->isPast();
    }

    public function bloquer()
    {
        $this->update(['statut' => 'bloque']);
    }

    public function activer()
    {
        $this->update(['statut' => 'actif']);
    }

    public function getTypeMoyenLibelleAttribute()
    {
        $types = [
            'carte' => 'Carte bancaire',
            'chequier' => 'Chéquier',
            'virement_permanent' => 'Virement permanent'
        ];
        
        return $types[$this->type_moyen] ?? $this->type_moyen;
    }

    public function getStatutLibelleAttribute()
    {
        $statuts = [
            'actif' => 'Actif',
            'bloque' => 'Bloqué',
            'expire' => 'Expiré',
            'en_attente' => 'En attente'
        ];
        
        return $statuts[$this->statut] ?? $this->statut;
    }

    public function scopeActifs($query)
    {
        return $query->where('statut', 'actif');
    }

    public function scopeParType($query, $type)
    {
        return $query->where('type_moyen', $type);
    }

    public function scopeBientotExpire($query, $jours = 30)
    {
        return $query->where('statut', 'actif')
                     ->whereNotNull('date_expiration')
                     ->whereBetween('date_expiration', [now(), now()->addDays($jours)]);
    }
}