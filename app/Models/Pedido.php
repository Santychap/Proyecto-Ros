<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

<<<<<<< HEAD
=======
    // Estados de pedido como constantes
    public const ESTADO_PENDIENTE = 'Pendiente';
    public const ESTADO_PAGADO = 'Pagado';
    public const ESTADO_CANCELADO = 'Cancelado';
    public const ESTADO_TERMINADO = 'Terminado'; // Opcional

>>>>>>> c5eafba12a8e0645d3d855a7405f2f47bcd1ef45
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

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class);
    }

<<<<<<< HEAD
    public function getNumeroAttribute()
=======
    // Accesor para obtener el total del pedido
    public function getTotalAttribute()
    {
        return $this->detalles->sum(function($detalle) {
            return $detalle->producto->precio * $detalle->cantidad;
        });
    }

    // Accesor para mostrar estado con íconos (opcional)
    public function getEstadoLabelAttribute()
>>>>>>> c5eafba12a8e0645d3d855a7405f2f47bcd1ef45
    {
        return 'PED-' . str_pad($this->id, 3, '0', STR_PAD_LEFT);
    }

    public function getClienteAttribute()
    {
        return $this->user->name ?? 'Cliente';
    }

    public function getTotalAttribute()
    {
        return rand(2500, 8500) / 100;
    }

    public function getMesaAttribute()
    {
        return (object)['numero' => rand(1, 20)];
    }
}