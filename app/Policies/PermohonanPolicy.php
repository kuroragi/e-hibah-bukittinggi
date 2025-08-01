<?php

namespace App\Policies;

use App\Models\Permohonan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PermohonanPolicy
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
    public function view(User $user, Permohonan $permohonan): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Permohonan $permohonan): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Permohonan $permohonan): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Permohonan $permohonan): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Permohonan $permohonan): bool
    {
        return false;
    }

    public function view_dukung(User $user) : bool {
        return $user->hasPermissionTo('View Dukung Permohonan');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function view_rab(User $user) : bool {
        return false;
    }

    public function check(User $user) : bool {
        return false;
    }

    public function send(User $user) : bool {
        return false;
    }

    public function review(User $user) : bool {
        return false;
    }

    public function reviewed(User $user) : bool {
        return false;
    }

    public function confirm_review(User $user) : bool {
        return false;
    }

    public function upload_rab(User $user) : bool {
        return false;
    }
}
