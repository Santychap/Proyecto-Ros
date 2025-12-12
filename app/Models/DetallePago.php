<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetallePago extends Model
{
    protected $table = 'detalle_pagos';  // o el nombre real de la tabla

    protected $fillable = [
        'pago_id',
        'descripcion',
        'monto',
        'datos_pago'
    ];

    protected $casts = [
        'datos_pago' => 'array',
        'monto' => 'decimal:2'
    ];

    public function pago()
    {
        return $this->belongsTo(Pago::class);
    }


}
