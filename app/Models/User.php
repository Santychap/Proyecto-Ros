<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // Roles disponibles
    const ROL_ADMIN = 'admin';
    const ROL_EMPLEADO = 'empleado';
    const ROL_CLIENTE = 'cliente';
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

    public function pedidos()
{
    return $this->hasMany(\App\Models\Pedido::class, 'empleado_id');
}

    public function isEmpleado()
    {
        return $this->hasRole(self::ROL_EMPLEADO);
    }

}
