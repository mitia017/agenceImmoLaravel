<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    // app/Policies/UserPolicy.php
    public function create(User $user)
    {
        return $user->isSuperAdmin();
    }

    public function updateRole(User $user, User $target)
    {
        if (!$user->isSuperAdmin()) return false;
        if ($target->role === User::ROLE_SUPERADMIN) return false; // pas toucher au superadmin
        return in_array($target->role, [User::ROLE_OWNER, User::ROLE_AGENT]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
