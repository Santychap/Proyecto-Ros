<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    const ESTADO_PENDIENTE = 'pendiente';
    const ESTADO_CONFIRMADA = 'confirmada';
    const ESTADO_CANCELADA = 'cancelada';
    const ESTADO_COMPLETADA = 'completada';

    protected $fillable = [
        'user_id',
        'fecha',
        'hora',
        'personas',
        'mesas',
        'motivo',
        'nota',
        'estado',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mesa()
    {
        return $this->belongsTo(Mesa::class, 'mesas');
    }

    public function isActiva()
    {
        return in_array($this->estado, [self::ESTADO_PENDIENTE, self::ESTADO_CONFIRMADA]);
    }
}
