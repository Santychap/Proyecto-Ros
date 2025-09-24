<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Remover columnas innecesarias de detalle_pagos
        Schema::table('detalle_pagos', function (Blueprint $table) {
            $table->dropForeign(['usuario_cambio_id']);
            $table->dropColumn(['usuario_cambio_id', 'accion']);
        });
    }

    public function down()
    {
        Schema::table('detalle_pagos', function (Blueprint $table) {
            $table->foreignId('usuario_cambio_id')->nullable()->constrained('users');
            $table->enum('accion', ['creacion', 'cambio_estado', 'cancelacion'])->default('creacion');
        });
    }
};