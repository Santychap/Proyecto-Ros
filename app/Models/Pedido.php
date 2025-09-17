<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pedido extends Model
{
    use HasFactory;

    // Estados de pedido como constantes
    public const ESTADO_PENDIENTE = 'Pendiente';
    public const ESTADO_PAGADO = 'Pagado';
    public const ESTADO_CANCELADO = 'Cancelado';
    public const ESTADO_TERMINADO = 'Terminado'; // Opcional

    protected $fillable = [
        'user_id',
        'estado',
        'comentario',
        'empleado_id'
    ];

    // Relación con el cliente que hizo el pedido
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el empleado asignado
    public function empleado()
    {
        return $this->belongsTo(User::class, 'empleado_id');
    }

    // Detalles del pedido (productos y cantidades)
    public function detalles()
    {
        return $this->hasMany(DetallePedido::class);
    }

    // Accesor para obtener el total del pedido
    public function getTotalAttribute()
    {
        return $this->detalles->sum(function($detalle) {
            return $detalle->producto->precio * $detalle->cantidad;
        });
    }

    // Accesor para mostrar estado con íconos (opcional)
    public function getEstadoLabelAttribute()
    {
        return match ($this->estado) {
            self::ESTADO_PENDIENTE => '⏳ Pendiente',
            self::ESTADO_PAGADO => '💰 Pagado',
            self::ESTADO_CANCELADO => '❌ Cancelado',
            self::ESTADO_TERMINADO => '✅ Terminado',
            default => $this->estado,
        };
    }

    // Verifica si el pedido ya está finalizado
    public function estaFinalizado()
    {
        return in_array($this->estado, [
            self::ESTADO_TERMINADO,
            self::ESTADO_CANCELADO
        ]);
    }
}
