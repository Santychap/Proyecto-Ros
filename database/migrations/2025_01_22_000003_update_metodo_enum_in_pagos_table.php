<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Primero actualizar datos existentes que no coinciden
        DB::statement("UPDATE pagos SET metodo = 'efectivo' WHERE metodo NOT IN ('efectivo')");
        
        // Luego cambiar el ENUM
        DB::statement("ALTER TABLE pagos MODIFY COLUMN metodo ENUM('efectivo','pse','nequi','daviplata','bancolombia') NOT NULL");
    }

    public function down()
    {
        DB::statement("ALTER TABLE pagos MODIFY COLUMN metodo ENUM('efectivo','tarjeta','transferencia') NOT NULL");
    }
};