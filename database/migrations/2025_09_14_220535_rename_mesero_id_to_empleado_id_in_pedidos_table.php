<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('pedidos', function (Blueprint $table) {
        $table->renameColumn('mesero_id', 'empleado_id');
    });
}

public function down()
{
    Schema::table('pedidos', function (Blueprint $table) {
        $table->renameColumn('empleado_id', 'mesero_id');
    });
}

};
