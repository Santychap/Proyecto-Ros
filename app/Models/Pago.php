<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedido_id',
        'user_id',
        'monto',
        'metodo',
        'fecha_pago',
        'datos_pago'
    ];

    protected $casts = [
        'fecha_pago' => 'datetime',
        'monto' => 'decimal:2',
        'datos_pago' => 'array'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}