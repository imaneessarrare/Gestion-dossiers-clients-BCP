<?php
// app/Models/Echeance.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Echeance extends Model
{
    use HasFactory;

    protected $table = 'echeances';
    protected $primaryKey = 'id_echeance';

    protected $fillable = [
        'date_echeance',
        'montant',
        'statut_paiement',
        'date_paiement',
        'id_credit'
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'date_echeance' => 'date',
        'date_paiement' => 'date'
    ];

    public function credit()
    {
        return $this->belongsTo(Credit::class, 'id_credit');
    }

    public function estEnRetard()
    {
        return $this->statut_paiement === 'en_attente' && $this->date_echeance->isPast();
    }

    public function marquerPayee()
    {
        $this->update([
            'statut_paiement' => 'paye',
            'date_paiement' => now()
        ]);

        // Vérifier si toutes les échéances sont payées
        $echeancesRestantes = $this->credit->echeances()
                                           ->where('statut_paiement', '!=', 'paye')
                                           ->count();

        if ($echeancesRestantes === 0) {
            $this->credit->update(['statut' => 'rembourse']);
        }
    }

    public function getMontantFormateAttribute()
    {
        return number_format($this->montant, 2, ',', ' ') . ' DH';
    }

    public function getStatutLibelleAttribute()
    {
        $statuts = [
            'paye' => 'Payée',
            'impaye' => 'Impayée',
            'en_attente' => 'En attente'
        ];
        
        return $statuts[$this->statut_paiement] ?? $this->statut_paiement;
    }

    public function scopeARisque($query)
    {
        return $query->where('statut_paiement', 'en_attente')
                     ->where('date_echeance', '<', now());
    }

    public function scopeAVenir($query, $jours = 30)
    {
        return $query->where('statut_paiement', 'en_attente')
                     ->whereBetween('date_echeance', [now(), now()->addDays($jours)]);
    }
}