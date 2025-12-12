<?php

namespace App\Policies;

use App\Models\Reserva;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReservaPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Reserva $reserva)
    {
        return $user->rol === 'admin' || ($user->rol === 'cliente' && $reserva->user_id === $user->id);
    }

    public function delete(User $user, Reserva $reserva)
    {
        return $user->rol === 'admin' || ($user->rol === 'cliente' && $reserva->user_id === $user->id);
    }
}
