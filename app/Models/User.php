<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',   // <- aquí asegúrate que esté 'role'
        // otros campos...
    ];

    // Método para comprobar rol
     public function hasRole($role)
    {
        return $this->rol === $role;
    }

    public function horarios()
{
    return $this->hasMany(Horario::class);
}
}
