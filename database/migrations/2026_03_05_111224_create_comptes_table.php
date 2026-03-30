<?php
// database/migrations/[timestamp]_create_comptes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('comptes', function (Blueprint $table) {
            $table->id('id_compte');
            $table->string('numero_compte', 30)->unique();
            $table->enum('type_compte', ['courant', 'epargne', 'joint']);
            $table->decimal('solde', 15, 2)->default(0); // En MAD
            $table->date('date_ouverture');
            $table->enum('statut', ['actif', 'bloque', 'ferme'])->default('actif');
            $table->foreignId('id_client')->constrained('clients', 'id_client')->onDelete('cascade');
            $table->timestamps();
            
            // Index pour améliorer les performances
            $table->index('numero_compte');
            $table->index('statut');
        });
    }

    public function down()
    {
        Schema::dropIfExists('comptes');
    }
};