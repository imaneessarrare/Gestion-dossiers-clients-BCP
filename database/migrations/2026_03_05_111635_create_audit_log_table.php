<?php
// database/migrations/[timestamp]_create_audit_log_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('audit_log', function (Blueprint $table) {
            $table->id('id_log');
            $table->foreignId('id_user')->nullable()->constrained('utilisateurs', 'id_user')->nullOnDelete();
            $table->string('action', 100);
            $table->string('table_concernee', 50);
            $table->unsignedBigInteger('id_enregistrement')->nullable();
            $table->text('anciennes_valeurs')->nullable();
            $table->text('nouvelles_valeurs')->nullable();
            $table->string('adresse_ip', 45)->nullable();
            $table->timestamps();
            
            $table->index('action');
            $table->index(['table_concernee', 'id_enregistrement']);
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('audit_log');
    }
};