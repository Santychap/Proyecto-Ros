<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetallePedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedido_id',
        'producto_id',
        'cantidad',
    ];

    // Relación inversa: Detalle pertenece a un pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    // Relación: Detalle pertenece a un producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    // Accesor opcional: Nombre del producto (para usar en vistas)
    public function getNombreProductoAttribute()
    {
        return $this->producto ? $this->producto->nombre : 'Producto eliminado';
    }

    // Accesor opcional: Precio total de este detalle (cantidad * precio)
    public function getSubtotalAttribute()
    {
        return $this->producto ? $this->cantidad * $this->producto->precio : 0;
    }

    public function aplicarDescuento($porcentaje)
    {
        return $this->subtotal * (1 - $porcentaje / 100);
    }

    public function validarCantidad()
    {
        return $this->cantidad > 0 && $this->cantidad <= ($this->producto->stock ?? 0);
    }
}
