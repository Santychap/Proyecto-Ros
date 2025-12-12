<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallePagosTable extends Migration
{
    public function up()
    {
        Schema::create('detalle_pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pago_id')->constrained()->onDelete('cascade');
            $table->string('descripcion')->nullable();
            $table->decimal('monto', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detalle_pagos');
    }
}