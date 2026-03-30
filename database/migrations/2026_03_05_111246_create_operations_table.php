<?php
// database/migrations/[timestamp]_create_operations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->id('id_operation');
            $table->enum('type_operation', ['depot', 'retrait', 'virement', 'prelevement', 'frais']);
            $table->decimal('montant', 15, 2); // En MAD
            $table->dateTime('date_operation')->useCurrent();
            $table->text('libelle')->nullable();
            $table->foreignId('id_compte')->constrained('comptes', 'id_compte')->onDelete('cascade');
            $table->foreignId('id_compte_dest')->nullable()->constrained('comptes', 'id_compte')->nullOnDelete();
            $table->timestamps();
            
            // Index pour les recherches fréquentes
            $table->index('date_operation');
            $table->index('type_operation');
            $table->index(['id_compte', 'date_operation']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('operations');
    }
};