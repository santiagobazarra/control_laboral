<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('participantes_evento', function (Blueprint $table) {
            $table->foreignId('id_evento')->constrained('eventos_calendario');
            $table->foreignId('id_usuario')->constrained('usuarios');
            $table->boolean('es_organizador')->default(false);
            $table->primary(['id_evento', 'id_usuario']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participantes_evento');
    }
};
