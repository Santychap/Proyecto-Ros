<?php

return [
    'email' => [
        'pedido_confirmado' => env('NOTIF_PEDIDO_CONFIRMADO', true),
        'pedido_completado' => env('NOTIF_PEDIDO_COMPLETADO', true),
        'reserva_confirmada' => env('NOTIF_RESERVA_CONFIRMADA', true),
    ],
    
    'sms' => [
        'enabled' => env('SMS_ENABLED', false),
        'provider' => env('SMS_PROVIDER', 'twilio'),
    ],
    
    'push' => [
        'enabled' => env('PUSH_ENABLED', false),
        'firebase_key' => env('FIREBASE_SERVER_KEY'),
    ],
    
    'tiempos' => [
        'recordatorio_reserva' => 60, // minutos antes
        'tiempo_max_preparacion' => 45, // minutos
    ],
];