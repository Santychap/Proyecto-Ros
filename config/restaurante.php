<?php

return [
    'nombre' => env('RESTAURANTE_NOMBRE', 'Mi Restaurante'),
    'telefono' => env('RESTAURANTE_TELEFONO', '+52 123 456 7890'),
    'direccion' => env('RESTAURANTE_DIRECCION', 'Calle Principal #123'),
    'horario_apertura' => env('RESTAURANTE_APERTURA', '08:00'),
    'horario_cierre' => env('RESTAURANTE_CIERRE', '22:00'),
    'capacidad_mesas' => env('RESTAURANTE_MESAS', 20),
];