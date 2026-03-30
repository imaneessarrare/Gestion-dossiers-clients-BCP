<?php
// app/Models/Client.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Client extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'clients';
    protected $primaryKey = 'id_client';

    protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'cin',
        'adresse',
        'telephone',
        'email',
        'situation_professionnelle',
        'revenus_mensuels',
        'statut',
        'id_user_creation'
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'revenus_mensuels' => 'decimal:2'
    ];

    // Relations
    public function userCreation()
    {
        return $this->belongsTo(User::class, 'id_user_creation');
    }

    public function comptes()
    {
        return $this->hasMany(Compte::class, 'id_client');
    }

    public function credits()
    {
        return $this->hasMany(Credit::class, 'id_client');
    }

    public function impayes()
    {
        return $this->hasMany(Impaye::class, 'id_client');
    }

    public function moyensPaiement()
    {
        return $this->hasMany(MoyenPaiement::class, 'id_client');
    }

    // Activity Log
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nom', 'prenom', 'email', 'telephone', 'statut'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    // Accesseurs
    public function getNomCompletAttribute()
    {
        return $this->nom . ' ' . $this->prenom;
    }

    // Scopes
    public function scopeActifs($query)
    {
        return $query->where('statut', 'actif');
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function($q) use ($term) {
            $q->where('nom', 'LIKE', "%{$term}%")
              ->orWhere('prenom', 'LIKE', "%{$term}%")
              ->orWhere('cin', 'LIKE', "%{$term}%")
              ->orWhere('email', 'LIKE', "%{$term}%");
        });
    }
}