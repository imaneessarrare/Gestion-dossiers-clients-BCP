<?php
// database/migrations/[timestamp]_create_impayes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('impayes', function (Blueprint $table) {
            $table->id('id_impaye');
            $table->decimal('montant', 15, 2); // En MAD
            $table->date('date_impaye');
            $table->enum('statut', ['nouveau', 'en_relance', 'resolu', 'contentieux'])->default('nouveau');
            $table->foreignId('id_client')->constrained('clients', 'id_client')->onDelete('cascade');
            $table->foreignId('id_credit')->nullable()->constrained('credits', 'id_credit')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Index
            $table->index('statut');
            $table->index('date_impaye');
            $table->index(['id_client', 'statut']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('impayes');
    }
};