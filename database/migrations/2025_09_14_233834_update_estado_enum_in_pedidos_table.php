<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEstadoEnumInPedidosTable extends Migration
{
    public function up()
    {
        // ⚠️ Para cambiar un enum, necesitas usar raw SQL o una librería como doctrine/dbal
        DB::statement("ALTER TABLE pedidos MODIFY estado ENUM('Pendiente', 'Pagado', 'Cancelado', 'Terminado') DEFAULT 'Pendiente'");
    }

    public function down()
    {
        // Revertir si quieres
        DB::statement("ALTER TABLE pedidos MODIFY estado ENUM('Pagado', 'Terminado') DEFAULT 'Pagado'");
    }
}
