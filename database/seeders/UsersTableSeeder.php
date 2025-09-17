<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Crear roles si no existen
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'empleado']);
        Role::firstOrCreate(['name' => 'cliente']);

        // Admin
        User::where('email', 'admin@restaurante.com')->delete();
        $admin = User::create([
            'name' => 'Admin Restaurante',
            'email' => 'admin@restaurante.com',
            'password' => Hash::make('password1234'),
        ]);
        $admin->assignRole('admin');

        // Empleado
        User::where('email', 'empleado@restaurante.com')->delete();
        $empleado = User::create([
            'name' => 'Empleado Mesero',
            'email' => 'empleado@restaurante.com',
            'password' => Hash::make('password1234'),
        ]);
        $empleado->assignRole('empleado');

        // Cliente
        User::where('email', 'cliente@restaurante.com')->delete();
        $cliente = User::create([
            'name' => 'Cliente Ejemplo',
            'email' => 'cliente@restaurante.com',
            'password' => Hash::make('password1234'),
        ]);
        $cliente->assignRole('cliente');
    }
}
