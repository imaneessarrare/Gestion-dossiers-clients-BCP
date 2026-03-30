<?php
// app/Models/Impaye.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Impaye extends Model
{
    use HasFactory;

    protected $table = 'impayes';
    protected $primaryKey = 'id_impaye';

    protected $fillable = [
        'montant',
        'date_impaye',
        'statut',
        'id_client',
        'id_credit',
        'notes'
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'date_impaye' => 'date'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }

    public function credit()
    {
        return $this->belongsTo(Credit::class, 'id_credit');
    }

    public function relancer()
    {
        $this->update([
            'statut' => 'en_relance',
            'notes' => $this->notes . "\nRelance effectuée le " . now()->format('d/m/Y')
        ]);

        // Créer une tâche de relance ou notification
        // Notification::send($this->client, new RelanceImpaye($this));
    }

    public function resoudre()
    {
        $this->update([
            'statut' => 'resolu'
        ]);

        if ($this->credit) {
            $echeance = $this->credit->echeances()
                                     ->where('date_echeance', $this->date_impaye)
                                     ->first();
            if ($echeance) {
                $echeance->marquerPayee();
            }
        }
    }

    public function getStatutLibelleAttribute()
    {
        $statuts = [
            'nouveau' => 'Nouvel impayé',
            'en_relance' => 'En relance',
            'resolu' => 'Résolu',
            'contentieux' => 'Contentieux'
        ];
        
        return $statuts[$this->statut] ?? $this->statut;
    }

    public function getMontantFormateAttribute()
    {
        return number_format($this->montant, 2, ',', ' ') . ' DH';
    }

    public function getJoursRetardAttribute()
    {
        return $this->date_impaye->diffInDays(now());
    }

    public function scopeNonResolus($query)
    {
        return $query->whereIn('statut', ['nouveau', 'en_relance', 'contentieux']);
    }

    public function scopeParPriorite($query)
    {
        return $query->orderByRaw("FIELD(statut, 'nouveau', 'en_relance', 'contentieux')")
                     ->orderBy('date_impaye');
    }
}