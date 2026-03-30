<?php
// app/Models/Credit.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    use HasFactory;

    protected $table = 'credits';
    protected $primaryKey = 'id_credit';

    protected $fillable = [
        'montant',
        'taux_interet',
        'duree_mois',
        'date_debut',
        'date_fin',
        'statut',
        'id_client'
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'taux_interet' => 'decimal:2',
        'date_debut' => 'date',
        'date_fin' => 'date'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }

    public function echeances()
    {
        return $this->hasMany(Echeance::class, 'id_credit');
    }

    public function impayes()
    {
        return $this->hasMany(Impaye::class, 'id_credit');
    }

    public function calculerMensualite()
    {
        $tauxMensuel = $this->taux_interet / 100 / 12;
        $mensualite = $this->montant * $tauxMensuel * pow(1 + $tauxMensuel, $this->duree_mois) / (pow(1 + $tauxMensuel, $this->duree_mois) - 1);
        
        return round($mensualite, 2);
    }

    public function genererEcheances()
    {
        $mensualite = $this->calculerMensualite();
        $dateEcheance = $this->date_debut->copy()->addMonth();

        for ($i = 1; $i <= $this->duree_mois; $i++) {
            $this->echeances()->create([
                'date_echeance' => $dateEcheance->copy(),
                'montant' => $mensualite,
                'statut_paiement' => 'en_attente'
            ]);
            
            $dateEcheance->addMonth();
        }
    }

    public function getMontantRestantAttribute()
    {
        $paye = $this->echeances()
                     ->where('statut_paiement', 'paye')
                     ->sum('montant');
        
        return $this->montant - $paye;
    }

    public function getProchaineEcheanceAttribute()
    {
        return $this->echeances()
                    ->where('statut_paiement', 'en_attente')
                    ->orderBy('date_echeance')
                    ->first();
    }

    public function getMensualiteFormateeAttribute()
    {
        return number_format($this->calculerMensualite(), 2, ',', ' ') . ' DH';
    }

    public function scopeEnCours($query)
    {
        return $query->whereIn('statut', ['en_cours', 'en_retard']);
    }

    public function scopeEnRetard($query)
    {
        return $query->where('statut', 'en_retard');
    }
}
