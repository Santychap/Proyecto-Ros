<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservasTable extends Migration
{
    public function up()
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('fecha');
            $table->time('hora');
            $table->integer('personas');
            $table->integer('mesas')->nullable();
            $table->enum('motivo', ['Cumpleaños', 'Aniversario', 'Cena de negocios', 'Otro'])->nullable();
            $table->text('nota')->nullable();
            $table->enum('estado', ['Pendiente', 'Confirmada'])->default('Confirmada');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservas');
    }
}
