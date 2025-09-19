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
        'categoria_id'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}
