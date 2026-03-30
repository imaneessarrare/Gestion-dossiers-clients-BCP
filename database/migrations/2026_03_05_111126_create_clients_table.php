<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_clients_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id('id_client');
            $table->string('nom');
            $table->string('prenom');
            $table->date('date_naissance');
            $table->string('cin')->unique();
            $table->text('adresse')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('situation_professionnelle')->nullable();
           $table->decimal('revenus_mensuels', 15, 2)->nullable(); // En MAD
            $table->enum('statut', ['actif', 'inactif', 'archive'])->default('actif');
            $table->foreignId('id_user_creation')->constrained('utilisateurs', 'id_user');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clients');
    }
};