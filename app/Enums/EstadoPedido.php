<?php

namespace App\Enums;

enum EstadoPedido: string
{
    case PENDIENTE = 'Pendiente';
    case EN_PROCESO = 'En Proceso';
    case COMPLETADO = 'Completado';
    case CANCELADO = 'Cancelado';
    case PAGADO = 'Pagado';
    case TERMINADO = 'Terminado';

    public function getColor(): string
    {
        return match($this) {
            self::PENDIENTE => 'yellow',
            self::EN_PROCESO => 'blue',
            self::COMPLETADO => 'green',
            self::CANCELADO => 'red',
            self::PAGADO => 'purple',
            self::TERMINADO => 'gray',
        };
    }

    public static function getOptions(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}