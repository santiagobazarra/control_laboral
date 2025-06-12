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
        Schema::create('fichajes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_usuario')->constrained('usuarios');
            $table->enum('tipo', ['ENTRADA', 'SALIDA', 'PAUSA_INICIO', 'PAUSA_FIN']);
            $table->timestampTz('hora_fichaje');
            $table->index('hora_fichaje', 'idx_fichajes_hora_fichaje');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fichajes');
    }
};
