<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Agregar campos a detalle_pagos
        Schema::table('detalle_pagos', function (Blueprint $table) {
            $table->text('datos_pago')->nullable()->after('monto');
            $table->foreignId('usuario_cambio_id')->nullable()->constrained('users')->after('datos_pago');
            $table->enum('accion', ['creacion', 'cambio_estado', 'cancelacion'])->default('creacion')->after('usuario_cambio_id');
        });

        // Migrar datos existentes de pagos a detalle_pagos (solo si existen)
        $pagosConDatos = DB::table('pagos')->whereNotNull('datos_pago')->count();
        if ($pagosConDatos > 0) {
            DB::statement("
                INSERT INTO detalle_pagos (pago_id, descripcion, monto, datos_pago, usuario_cambio_id, accion, created_at, updated_at)
                SELECT 
                    id as pago_id,
                    CONCAT('Estado: ', estado) as descripcion,
                    monto,
                    datos_pago,
                    user_id as usuario_cambio_id,
                    'creacion' as accion,
                    created_at,
                    updated_at
                FROM pagos 
                WHERE datos_pago IS NOT NULL
            ");
        }

        // Remover datos_pago de pagos (verificar si existe)
        if (Schema::hasColumn('pagos', 'datos_pago')) {
            Schema::table('pagos', function (Blueprint $table) {
                $table->dropColumn('datos_pago');
            });
        }
    }

    public function down()
    {
        // Restaurar datos_pago en pagos
        Schema::table('pagos', function (Blueprint $table) {
            $table->text('datos_pago')->nullable();
        });

        // Migrar datos de vuelta
        DB::statement("
            UPDATE pagos p 
            SET datos_pago = (
                SELECT dp.datos_pago 
                FROM detalle_pagos dp 
                WHERE dp.pago_id = p.id 
                AND dp.datos_pago IS NOT NULL 
                LIMIT 1
            )
        ");

        // Remover campos de detalle_pagos
        Schema::table('detalle_pagos', function (Blueprint $table) {
            $table->dropForeign(['usuario_cambio_id']);
            $table->dropColumn(['datos_pago', 'usuario_cambio_id', 'accion']);
        });
    }
};