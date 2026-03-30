<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'utilisateurs';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'login',
        'nom',
        'email',
        'mot_de_passe_hash',
        'role',
        'statut',
        'derniere_connexion'
    ];

    protected $hidden = [
        'mot_de_passe_hash',
        'remember_token',
    ];

    protected $casts = [
        'derniere_connexion' => 'datetime',
    ];

    public function getAuthPassword()
    {
        return $this->mot_de_passe_hash;
    }
}