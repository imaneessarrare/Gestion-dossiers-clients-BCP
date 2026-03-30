<?php
// database/migrations/[timestamp]_create_documents_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id('id_document');
            $table->string('type_document', 50);
            $table->string('nom_fichier', 255);
            $table->string('chemin_fichier', 500);
            $table->foreignId('id_client')->constrained('clients', 'id_client')->onDelete('cascade');
            $table->foreignId('uploaded_by')->constrained('utilisateurs', 'id_user');
            $table->timestamps();
            
            $table->index(['id_client', 'type_document']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents');
    }
};