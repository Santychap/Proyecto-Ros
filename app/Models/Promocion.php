<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Promocion extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'descuento',
        'fecha_inicio',
        'fecha_fin',
        'imagen',
    ];

    // Si usas nombre de tabla en español
    protected $table = 'promociones';

    // Aquí definimos los casts para que Laravel convierta automáticamente a Carbon
    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
    ];
}
