<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Eliminar columna temporal si existe
        if (Schema::hasColumn('inventario', 'cantidad_minima_old')) {
            Schema::table('inventario', function (Blueprint $table) {
                $table->dropColumn('cantidad_minima_old');
            });
        }
        
        // Hacer código único si no lo es ya
        try {
            Schema::table('inventario', function (Blueprint $table) {
                $table->string('codigo')->unique()->change();
            });
        } catch (Exception $e) {
            // Ya es único, continuar
        }
    }

    public function down()
    {
        // No hacer nada en rollback
    }
};