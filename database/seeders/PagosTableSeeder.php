<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pago;
use App\Models\Pedido;

class PagosTableSeeder extends Seeder
{
    public function run()
    {
        $pedidos = Pedido::all();
        
        if ($pedidos->count() > 0) {
            Pago::create([
                'pedido_id' => $pedidos->first()->id,
                'user_id' => $pedidos->first()->user_id,
                'monto' => 45.50,
                'metodo' => 'efectivo',
                'fecha_pago' => now()
            ]);

            Pago::create([
                'pedido_id' => $pedidos->skip(1)->first()->id ?? $pedidos->first()->id,
                'user_id' => $pedidos->skip(1)->first()->user_id ?? $pedidos->first()->user_id,
                'monto' => 32.75,
                'metodo' => 'tarjeta',
                'fecha_pago' => now()->subHours(2)
            ]);

            Pago::create([
                'pedido_id' => $pedidos->skip(2)->first()->id ?? $pedidos->first()->id,
                'user_id' => $pedidos->skip(2)->first()->user_id ?? $pedidos->first()->user_id,
                'monto' => 28.90,
                'metodo' => 'tarjeta',
                'fecha_pago' => now()->subHours(1)
            ]);
        }
    }
}