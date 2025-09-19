<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos');
            $table->decimal('monto', 10, 2);
            $table->enum('metodo', ['efectivo', 'tarjeta', 'transferencia', 'qr']);
            $table->datetime('fecha');
            $table->enum('estado', ['pendiente', 'completado', 'fallido'])->default('pendiente');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pagos');
    }
};