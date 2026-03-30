<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_utilisateurs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('login')->unique();
            $table->string('mot_de_passe_hash');
            $table->string('nom');
            $table->string('email')->unique();
            $table->enum('role', ['admin', 'employe', 'superviseur'])->default('employe');
            $table->enum('statut', ['actif', 'inactif'])->default('actif');
            $table->timestamps();
            $table->timestamp('derniere_connexion')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('utilisateurs');
    }
};