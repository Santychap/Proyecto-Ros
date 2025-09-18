<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reserva;  // <-- Importar Reserva para usarlo en la relación

class Mesa extends Model
{
    use HasFactory;

    protected $fillable = ['codigo', 'capacidad'];

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}
