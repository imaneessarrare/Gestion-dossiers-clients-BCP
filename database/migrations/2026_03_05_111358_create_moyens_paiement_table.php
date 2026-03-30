<?php
// database/migrations/[timestamp]_create_moyens_paiement_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('moyens_paiement', function (Blueprint $table) {
            $table->id('id_moyen');
            $table->enum('type_moyen', ['carte', 'chequier', 'virement_permanent']);
            $table->string('numero', 50)->nullable();
            $table->date('date_emission')->nullable();
            $table->date('date_expiration')->nullable();
            $table->enum('statut', ['actif', 'bloque', 'expire', 'en_attente'])->default('actif');
            $table->foreignId('id_client')->constrained('clients', 'id_client')->onDelete('cascade');
            $table->timestamps();
            
            // Index
            $table->index('statut');
            $table->index('date_expiration');
            $table->index(['id_client', 'type_moyen']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('moyens_paiement');
    }
};