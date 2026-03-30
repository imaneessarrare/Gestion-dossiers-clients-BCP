<?php
// database/migrations/[timestamp]_create_credits_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('credits', function (Blueprint $table) {
            $table->id('id_credit');
            $table->decimal('montant', 15, 2); // En MAD
            $table->decimal('taux_interet', 5, 2);
            $table->integer('duree_mois');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->enum('statut', ['en_cours', 'rembourse', 'en_retard', 'rejete'])->default('en_cours');
            $table->foreignId('id_client')->constrained('clients', 'id_client')->onDelete('cascade');
            $table->timestamps();
            
            // Index
            $table->index('statut');
            $table->index(['id_client', 'statut']);
            $table->index('date_fin');
        });
    }

    public function down()
    {
        Schema::dropIfExists('credits');
    }
};