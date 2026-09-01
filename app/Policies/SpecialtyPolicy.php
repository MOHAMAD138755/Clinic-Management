<?php

namespace App\Policies;

use App\Models\Specialty;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SpecialtyPolicy
{
    public function before(User $user, $ability): ?bool
    {
        if ($user->hasRole(['Super Admin'])) {
            return true;
        }

        return null;
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['User Admin','Editor','Super Admin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Specialty $specialty): bool
    {
        return $user->hasRole(['User Admin','Editor','Super Admin']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(['User Admin','Editor','Super Admin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Specialty $specialty): bool
    {
        return $user->hasRole(['Super Admin','User Admin']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Specialty $specialty): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Specialty $specialty): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Specialty $specialty): bool
    {
        return false;
    }
}
