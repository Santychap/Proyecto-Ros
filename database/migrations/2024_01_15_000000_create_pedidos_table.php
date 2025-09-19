<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique();
            $table->string('cliente');
            $table->foreignId('mesa_id')->constrained('mesas');
            $table->decimal('total', 10, 2);
            $table->enum('estado', ['pendiente', 'preparando', 'listo', 'entregado', 'pagado'])->default('pendiente');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
};