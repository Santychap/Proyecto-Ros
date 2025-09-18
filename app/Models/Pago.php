<?php

namespace App\Models;

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
        'datos_pago',
        'fecha_pago',
    ];

    // Relación con el pedido asociado
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

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
