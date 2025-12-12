<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriasSeeder extends Seeder
{
    public function run()
    {
        $categorias = [
            'Entradas',
            'Platos Principales',
            'Postres',
            'Bebidas',
            'Ensaladas',
            'Sopas',
            'Especialidades',
            'Infantil'
        ];

        foreach ($categorias as $categoria) {
            Categoria::firstOrCreate(['nombre' => $categoria]);
        }
    }
}