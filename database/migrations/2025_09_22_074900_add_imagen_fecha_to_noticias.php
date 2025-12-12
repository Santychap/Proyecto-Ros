<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('noticias', function (Blueprint $table) {
            $table->string('imagen')->nullable()->after('contenido');
            $table->timestamp('fecha_publicacion')->nullable()->after('imagen');
        });
    }

    public function down()
    {
        Schema::table('noticias', function (Blueprint $table) {
            $table->dropColumn(['imagen', 'fecha_publicacion']);
        });
    }
};