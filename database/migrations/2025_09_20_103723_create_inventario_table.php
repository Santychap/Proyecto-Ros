<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inventario', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Nombre del ingrediente (ej: Pollo, Papa, Cebolla)
            $table->text('descripcion')->nullable();
            $table->enum('tipo', ['proteina', 'verdura', 'condimento', 'lacteo', 'cereal', 'bebida', 'otro'])->default('otro');
            $table->integer('cantidad_actual')->default(0);
            $table->integer('cantidad_minima')->default(0);
            $table->string('unidad_medida'); // kg, litros, unidades, gramos, etc.
            $table->decimal('precio_unitario', 10, 2)->default(0);
            $table->string('proveedor')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->enum('estado', ['disponible', 'agotado', 'por_vencer'])->default('disponible');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventario');
    }
};