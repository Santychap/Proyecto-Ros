<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Producto;
use App\Models\Inventario;

return new class extends Migration
{
    public function up()
    {
        // Migrar productos existentes al inventario
        $productos = Producto::all();
        
        foreach ($productos as $producto) {
            Inventario::create([
                'nombre' => $producto->nombre,
                'descripcion' => $producto->descripcion,
                'cantidad_actual' => $producto->stock ?? 50,
                'cantidad_minima' => 10,
                'unidad_medida' => 'unidad',
                'precio_unitario' => $producto->precio,
                'proveedor' => 'Proveedor Principal',
                'fecha_vencimiento' => now()->addMonths(6),
                'estado' => 'disponible'
            ]);
        }
    }

    public function down()
    {
        // Limpiar inventario
        Inventario::truncate();
    }
};