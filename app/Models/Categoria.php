<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    // 👇 Aquí especificamos el nombre real de la tabla
    protected $table = 'categorias';

    // Los campos que se pueden asignar masivamente
    protected $fillable = ['nombre'];

    // Relación: Una categoría tiene muchos productos
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

    public function productosDisponibles()
    {
        return $this->productos()->where('stock', '>', 0);
    }

    public function getTotalProductosAttribute()
    {
        return $this->productos()->count();
    }
}
