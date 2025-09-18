<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToPagosTable extends Migration
{
    public function up()
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('pedido_id');

            // Crear clave foránea que referencia a la tabla users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('pagos', function (Blueprint $table) {
            // Primero eliminamos la clave foránea
            $table->dropForeign(['user_id']);
            // Luego eliminamos la columna
            $table->dropColumn('user_id');
        });
    }
}
