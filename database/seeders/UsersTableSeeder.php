<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Eliminar si existe antes de crear
        User::where('email', 'admin@restaurante.com')->delete();
        User::create([
            'name' => 'Admin Restaurante',
            'email' => 'admin@restaurante.com',
            'password' => Hash::make('password1234'),
            'rol' => 'admin',
        ]);

        User::where('email', 'empleado@restaurante.com')->delete();
        User::create([
            'name' => 'Empleado Mesero',
            'email' => 'empleado@restaurante.com',
            'password' => Hash::make('password1234'),
            'rol' => 'empleado',
        ]);

        User::where('email', 'cliente@restaurante.com')->delete();
        User::create([
            'name' => 'Cliente Ejemplo',
            'email' => 'cliente@restaurante.com',
            'password' => Hash::make('password1234'),
            'rol' => 'cliente',
        ]);
    }
}
