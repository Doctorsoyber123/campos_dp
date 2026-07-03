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
        Schema::create('infraestructuras', function (Blueprint $table) {
            $table->id();
            $table->string('denominacion');
            $table->string('tipo')->nullable();
            $table->string('sector')->nullable();
            $table->string('direccion')->nullable();
            $table->unsignedInteger('aforo')->nullable();
            $table->string('modalidad')->nullable();
            $table->string('imagen_referencia')->nullable();
            // El resto de los ~80 campos de la ficha (uso de espacio, ficha técnica,
            // servicios básicos, defensa civil, etc.) se guardan aquí para no tener
            // una tabla de 90 columnas; los campos que necesiten filtrarse/reportarse
            // con frecuencia pueden "graduarse" a columna propia más adelante.
            $table->json('detalle')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infraestructuras');
    }
};
