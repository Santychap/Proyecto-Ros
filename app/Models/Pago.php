<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    const METODO_EFECTIVO = 'efectivo';
    const METODO_TARJETA = 'tarjeta';
    const METODO_TRANSFERENCIA = 'transferencia';

    protected $fillable = [
        'pedido_id',
        'user_id',
        'monto',
        'metodo',
        'estado',
        'fecha_pago'
    ];

    protected $casts = [
        'fecha_pago' => 'datetime',
        'monto' => 'decimal:2'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function detalles()
    {
        return $this->hasMany(DetallePago::class);
    }

    public function isPagado()
    {
        return $this->estado === 'pagado';
    }
}