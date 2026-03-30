<?php
// database/migrations/[timestamp]_create_echeances_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('echeances', function (Blueprint $table) {
            $table->id('id_echeance');
            $table->date('date_echeance');
            $table->decimal('montant', 15, 2); // En MAD
            $table->enum('statut_paiement', ['paye', 'impaye', 'en_attente'])->default('en_attente');
            $table->date('date_paiement')->nullable();
            $table->foreignId('id_credit')->constrained('credits', 'id_credit')->onDelete('cascade');
            $table->timestamps();
            
            // Index pour les alertes et suivis
            $table->index('date_echeance');
            $table->index('statut_paiement');
            $table->index(['id_credit', 'statut_paiement']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('echeances');
    }
};