<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMesasColumnInReservasTable extends Migration
{
    public function up()
    {
        Schema::table('reservas', function (Blueprint $table) {
            // Si el campo ya existe como 'mesas', renómbralo
            if (Schema::hasColumn('reservas', 'mesas')) {
                $table->renameColumn('mesas', 'mesa_id');
            }

            // Asegúrate de que sea unsignedBigInteger (si no lo era)
            $table->unsignedBigInteger('mesa_id')->change();

            // Agrega clave foránea (asegúrate de que la tabla 'mesas' exista)
            $table->foreign('mesa_id')->references('id')->on('mesas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->dropForeign(['mesa_id']);
            $table->renameColumn('mesa_id', 'mesas');
        });
    }
}
