<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function manageUsers(User $user)
    {
        return $user->role === 'admin';
    }

    public function viewAny(User $user)
    {
        return $this->manageUsers($user);
    }

    public function view(User $user, User $model)
    {
        return $this->manageUsers($user);
    }

    public function create(User $user)
    {
        return $this->manageUsers($user);
    }

    public function update(User $user, User $model)
    {
        return $this->manageUsers($user);
    }

    public function delete(User $user, User $model)
    {
        return $this->manageUsers($user);
    }
}
