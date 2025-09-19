<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

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
        return rand(2500, 8500) / 100;
    }

    public function getMesaAttribute()
    {
        return (object)['numero' => rand(1, 20)];
    }
}