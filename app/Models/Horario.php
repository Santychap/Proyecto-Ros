<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dia',
        'hora_entrada',
        'hora_salida',
    ];

    // Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getHorasTrabajadasAttribute()
    {
        $entrada = \Carbon\Carbon::createFromFormat('H:i:s', $this->hora_entrada);
        $salida = \Carbon\Carbon::createFromFormat('H:i:s', $this->hora_salida);
        return $salida->diffInHours($entrada);
    }

    public function estaTrabajando($horaActual = null)
    {
        $horaActual = $horaActual ?? now()->format('H:i:s');
        return $horaActual >= $this->hora_entrada && $horaActual <= $this->hora_salida;
    }
}
