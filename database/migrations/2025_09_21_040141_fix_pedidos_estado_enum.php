<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Agregar nuevos estados 'En Proceso' y 'Completado' al enum de estado
        DB::statement("ALTER TABLE pedidos MODIFY COLUMN estado ENUM('Pendiente','En Proceso','Completado','Cancelado','Pagado','Terminado')");
    }

    public function down(): void
    {
        // Revertir a los estados originales del enum
        DB::statement("ALTER TABLE pedidos MODIFY COLUMN estado ENUM('Pendiente','Pagado','Cancelado','Terminado')");
    }
};