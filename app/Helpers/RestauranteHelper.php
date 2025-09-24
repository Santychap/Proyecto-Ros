<?php

namespace App\Helpers;

class RestauranteHelper
{
    public static function formatearPrecio($precio)
    {
        return '$' . number_format($precio, 2);
    }

    public static function generarNumeroOrden($id)
    {
        return 'ORD-' . str_pad($id, 6, '0', STR_PAD_LEFT);
    }

    public static function calcularTiempoEspera($cantidadPedidos)
    {
        return max(15, $cantidadPedidos * 5) . ' minutos';
    }
}