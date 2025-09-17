<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'contenido',
        'imagen',
        'fecha_publicacion',
    ];

    // Si usas nombre de tabla en español
    protected $table = 'noticias';
}
