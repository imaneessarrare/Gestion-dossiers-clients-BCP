<?php
// app/Models/Document.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    protected $table = 'documents';
    protected $primaryKey = 'id_document';

    protected $fillable = [
        'type_document',
        'nom_fichier',
        'chemin_fichier',
        'id_client',
        'uploaded_by'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }

    public function uploader()
    {
        return $this->belongsTo(Utilisateur::class, 'uploaded_by');
    }

    public function getUrlAttribute()
    {
        return Storage::url($this->chemin_fichier);
    }

    public function getTailleFormateeAttribute()
    {
        if (Storage::exists($this->chemin_fichier)) {
            $bytes = Storage::size($this->chemin_fichier);
            $units = ['B', 'KB', 'MB', 'GB'];
            
            for ($i = 0; $bytes > 1024; $i++) {
                $bytes /= 1024;
            }
            
            return round($bytes, 2) . ' ' . $units[$i];
        }
        
        return 'Inconnu';
    }

    public function scopeParType($query, $type)
    {
        return $query->where('type_document', $type);
    }

    protected static function booted()
    {
        static::deleting(function ($document) {
            Storage::delete($document->chemin_fichier);
        });
    }
}