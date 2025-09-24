<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pedido;
use App\Models\User;

class PedidosTableSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        
        if ($users->count() > 0) {
            Pedido::create([
                'user_id' => $users->first()->id,
                'estado' => 'pendiente',
                'comentario' => 'Pedido completado'
            ]);

            Pedido::create([
                'user_id' => $users->skip(1)->first()->id ?? $users->first()->id,
                'estado' => 'pendiente',
                'comentario' => 'Listo para entregar'
            ]);

            Pedido::create([
                'user_id' => $users->skip(2)->first()->id ?? $users->first()->id,
                'estado' => 'pendiente',
                'comentario' => 'En preparación'
            ]);
        }
    }
}