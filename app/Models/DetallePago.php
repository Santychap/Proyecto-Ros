<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetallePago extends Model
{
    protected $table = 'detalle_pagos';  // o el nombre real de la tabla

    protected $fillable = [
        'pago_id',
        'descripcion', // o el campo que uses para detalle
        'monto',       // ejemplo de campo adicional
        // otros campos que tenga detalle_pago
    ];

    public function pago()
    {
        return $this->belongsTo(Pago::class);
    }
}
