<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    // Indica el nombre exacto de la tabla en la base de datos
    protected $table = 'productos'; // Cambia 'products' por el nombre correcto de tu tabla

    protected $fillable = [
        'nombre',
        'descripcion',
        'ingredientes',
        'precio',
        'stock',
        'image',
        'imagen', // Soporte para ambos nombres
        'category_id'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'category_id');
    }

    // Accessor para obtener la URL completa de la imagen
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        } elseif ($this->imagen) {
            return asset('storage/' . $this->imagen);
        }
        return null;
    }

    // Verificar si tiene imagen
    public function hasImage()
    {
        return !empty($this->image) || !empty($this->imagen);
    }

    // Verificar disponibilidad
    public function isDisponible()
    {
        return $this->stock > 0;
    }

    // Formatear precio
    public function getPrecioFormateadoAttribute()
    {
        return '$' . number_format($this->precio, 2);
    }
}
