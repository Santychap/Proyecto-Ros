<?php

namespace App\Constants;

class RestauranteConstants
{
    // Estados de pedidos
    const PEDIDO_PENDIENTE = 'Pendiente';
    const PEDIDO_EN_PROCESO = 'En Proceso';
    const PEDIDO_COMPLETADO = 'Completado';
    const PEDIDO_CANCELADO = 'Cancelado';
    const PEDIDO_PAGADO = 'Pagado';
    const PEDIDO_TERMINADO = 'Terminado';

    // Métodos de pago
    const PAGO_EFECTIVO = 'efectivo';
    const PAGO_TARJETA = 'tarjeta';
    const PAGO_TRANSFERENCIA = 'transferencia';

    // Roles de usuario
    const ROL_ADMIN = 'admin';
    const ROL_EMPLEADO = 'empleado';
    const ROL_CLIENTE = 'cliente';

    // Estados de reserva
    const RESERVA_PENDIENTE = 'pendiente';
    const RESERVA_CONFIRMADA = 'confirmada';
    const RESERVA_CANCELADA = 'cancelada';
    const RESERVA_COMPLETADA = 'completada';
}