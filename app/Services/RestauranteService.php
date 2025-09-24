<?php

namespace App\Services;

use App\Models\Pedido;
use App\Models\Producto;

class RestauranteService
{
    public function calcularVentasDelDia($fecha = null)
    {
        $fecha = $fecha ?? now()->toDateString();
        return Pedido::whereDate('created_at', $fecha)
            ->where('estado', 'Pagado')
            ->sum('total');
    }

    public function obtenerProductosMasVendidos($limite = 5)
    {
        return Producto::withCount('detalles')
            ->orderBy('detalles_count', 'desc')
            ->limit($limite)
            ->get();
    }

    public function calcularTiempoPromedioAtencion()
    {
        return Pedido::where('estado', 'Terminado')
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, created_at, updated_at)) as promedio')
            ->value('promedio') ?? 0;
    }
}