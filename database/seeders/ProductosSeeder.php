<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductosSeeder extends Seeder
{
    public function run()
    {
        $productos = [
            [
                'nombre' => 'Bandeja Paisa',
                'descripcion' => 'Plato típico antioqueño con frijoles, arroz, carne molida, chicharrón, chorizo, morcilla, huevo frito, patacón y aguacate.',
                'precio' => 25000,
                'stock' => 50,
                'category_id' => 1,
                'image' => 'imagenes/bandeja-paisa-1616.gif',
                'ingredientes' => 'Frijoles, arroz, carne molida, chicharrón, chorizo, morcilla, huevo, plátano, aguacate'
            ],
            [
                'nombre' => 'Ajiaco Santafereño',
                'descripcion' => 'Sopa tradicional bogotana con pollo, papas criollas, sabaneras y pastusas, mazorca y guascas.',
                'precio' => 18000,
                'stock' => 30,
                'category_id' => 1,
                'image' => 'imagenes/ajiaco_nestle_1200x800_2022.jpg',
                'ingredientes' => 'Pollo, papas criollas, papas sabaneras, papas pastusas, mazorca, guascas, alcaparras, crema de leche'
            ],
            [
                'nombre' => 'Mojarra Frita',
                'descripcion' => 'Mojarra fresca frita acompañada de arroz con coco, patacones y ensalada.',
                'precio' => 22000,
                'stock' => 25,
                'category_id' => 1,
                'image' => 'imagenes/mojarra ejecutiva.jpg',
                'ingredientes' => 'Mojarra fresca, arroz con coco, plátano verde, ensalada, limón'
            ],
            [
                'nombre' => 'Churrasco a la Plancha',
                'descripcion' => 'Jugoso churrasco a la plancha acompañado de papas francesas, ensalada y chimichurri.',
                'precio' => 28000,
                'stock' => 20,
                'category_id' => 1,
                'image' => 'imagenes/receta-de-Churrasco-a-la-Plancha.jpg',
                'ingredientes' => 'Carne de res, papas, lechuga, tomate, chimichurri'
            ],
            [
                'nombre' => 'Pechuga Gratinada',
                'descripcion' => 'Pechuga de pollo gratinada con queso, acompañada de arroz y verduras salteadas.',
                'precio' => 19000,
                'stock' => 35,
                'category_id' => 1,
                'image' => 'imagenes/Pechuga-gratinada.jpeg',
                'ingredientes' => 'Pechuga de pollo, queso mozzarella, arroz, verduras mixtas'
            ],
            [
                'nombre' => 'Trucha Frita',
                'descripcion' => 'Trucha fresca frita acompañada de arroz, ensalada y patacones.',
                'precio' => 24000,
                'stock' => 15,
                'category_id' => 1,
                'image' => 'imagenes/TruchaFrita.jpg',
                'ingredientes' => 'Trucha fresca, arroz blanco, ensalada mixta, plátano verde'
            ]
        ];

        foreach ($productos as $producto) {
            Producto::updateOrCreate(
                ['nombre' => $producto['nombre']],
                $producto
            );
        }
    }
}