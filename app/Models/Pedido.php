<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    // Estados disponibles para pedidos
    const ESTADO_PENDIENTE = 'Pendiente';
    const ESTADO_EN_PROCESO = 'En Proceso';
    const ESTADO_COMPLETADO = 'Completado';
    const ESTADO_CANCELADO = 'Cancelado';
    const ESTADO_PAGADO = 'Pagado';
    const ESTADO_TERMINADO = 'Terminado';

    protected $fillable = [
        'user_id',
        'estado',
        'comentario',
        'empleado_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function empleado()
    {
        return $this->belongsTo(User::class, 'empleado_id');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    public function pago()
    {
        return $this->hasOne(Pago::class);
    }

    public function getEstadoPagoAttribute()
    {
        return $this->pago ? $this->pago->estado : 'pendiente';
    }

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class);
    }

    public function getNumeroAttribute()
    {
        return 'PED-' . str_pad($this->id, 3, '0', STR_PAD_LEFT);
    }

    public function getClienteAttribute()
    {
        return $this->user->name ?? 'Cliente';
    }

    public function getTotalAttribute()
    {
        return $this->detalles->sum(function($detalle) {
            return $detalle->cantidad * $detalle->producto->precio;
        });
    }

    public function getMesaAttribute()
    {
        return (object)['numero' => rand(1, 20)];
    }

    public function isCompletado()
    {
        return $this->estado === self::ESTADO_COMPLETADO;
    }
}