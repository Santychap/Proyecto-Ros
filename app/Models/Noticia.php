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

    protected $casts = [
        'fecha_publicacion' => 'datetime',
    ];

    // Si usas nombre de tabla en español
    protected $table = 'noticias';

    public function isReciente($dias = 7)
    {
        return $this->fecha_publicacion >= now()->subDays($dias);
    }

    public function getResumenAttribute($limite = 150)
    {
        return strlen($this->contenido) > $limite 
            ? substr($this->contenido, 0, $limite) . '...' 
            : $this->contenido;
    }

    public function scopeRecientes($query, $dias = 30)
    {
        return $query->where('fecha_publicacion', '>=', now()->subDays($dias));
    }
}
