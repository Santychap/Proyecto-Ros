<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedido_id',
        'user_id',
        'monto',
        'metodo',
<<<<<<< HEAD
        'fecha_pago',
        'datos_pago'
    ];

    protected $casts = [
        'fecha_pago' => 'datetime',
        'monto' => 'decimal:2',
        'datos_pago' => 'array'
    ];

=======
        'datos_pago',
        'fecha_pago',
    ];

    // Relación con el pedido asociado
>>>>>>> c5eafba12a8e0645d3d855a7405f2f47bcd1ef45
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
<<<<<<< HEAD
}
=======

    // Relación con el usuario que realizó el pago
    public function user()
    {
        return $this->belongsTo(User::class);
    }

   protected $casts = [
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
    'fecha_pago' => 'datetime', // <- agrega esta línea
];

public function detalles()
{
    return $this->hasMany(DetallePago::class);
}
}
>>>>>>> c5eafba12a8e0645d3d855a7405f2f47bcd1ef45
