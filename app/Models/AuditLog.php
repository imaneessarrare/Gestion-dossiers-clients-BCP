<?php
// app/Models/AuditLog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $table = 'audit_log';
    protected $primaryKey = 'id_log';

    protected $fillable = [
        'id_user',
        'action',
        'table_concernee',
        'id_enregistrement',
        'anciennes_valeurs',
        'nouvelles_valeurs',
        'adresse_ip'
    ];

    protected $casts = [
        'anciennes_valeurs' => 'array',
        'nouvelles_valeurs' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(Utilisateur::class, 'id_user');
    }

    public static function log($action, $model, $oldValues = null, $newValues = null)
    {
        return self::create([
            'id_user' => auth()->id(),
            'action' => $action,
            'table_concernee' => $model->getTable(),
            'id_enregistrement' => $model->id,
            'anciennes_valeurs' => $oldValues ? json_encode($oldValues) : null,
            'nouvelles_valeurs' => $newValues ? json_encode($newValues) : null,
            'adresse_ip' => request()->ip()
        ]);
    }

    public function scopeParUtilisateur($query, $userId)
    {
        return $query->where('id_user', $userId);
    }

    public function scopeParTable($query, $table)
    {
        return $query->where('table_concernee', $table);
    }

    public function scopeParAction($query, $action)
    {
        return $query->where('action', $action);
    }

    public function scopeEntreDates($query, $debut, $fin)
    {
        return $query->whereBetween('created_at', [$debut, $fin]);
    }
}