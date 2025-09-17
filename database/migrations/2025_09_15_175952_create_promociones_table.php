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
        Schema::create('promociones', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->decimal('descuento', 5, 2)->nullable(); // Ej: 20.00 (%)
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('imagen')->nullable(); // opcional, si deseas subir imágenes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promociones'); // CORREGIDO: de 'promocions' a 'promociones'
    }
};
