<?php

namespace Database\Factories;

use App\Models\Pedido;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PedidoFactory extends Factory
{
    protected $model = Pedido::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'estado' => $this->faker->randomElement(['Pendiente', 'En Proceso', 'Completado']),
            'comentario' => $this->faker->optional()->sentence(),
            'empleado_id' => User::factory(),
            'total' => $this->faker->randomFloat(2, 50, 500),
        ];
    }

    public function pendiente()
    {
        return $this->state(['estado' => 'Pendiente']);
    }

    public function completado()
    {
        return $this->state(['estado' => 'Completado']);
    }
}