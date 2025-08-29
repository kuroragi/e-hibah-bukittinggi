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
        return $user->hasPermissionTo('View Any Permohonan');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create Permohonan');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return $user->hasPermissionTo('Update Permohonan');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
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
        return $user->hasPermissionTo('View Rab Permohonan');
    }

    public function check(User $user) : bool {
        return $user->hasPermissionTo('Check Permohonan');
    }

    public function send(User $user) : bool {
        return $user->hasPermissionTo('Send Permohonan');
    }

    public function review(User $user) : bool {
        return $user->hasPermissionTo('Review Permohonan');
    }

    public function reviewed(User $user) : bool {
        return $user->hasPermissionTo('Reviewed Permohonan');
    }

    public function confirm_review(User $user) : bool {
        return $user->hasPermissionTo('Confirm Review Permohonan');
    }

    public function upload_rab(User $user) : bool {
        return $user->hasPermissionTo('Updload Rab Permohonan');
    }

    public function download_pemberitahuan(User $user) : bool {
        return $user->hasPermissionTo('Download Pemberitahuan Koreksi');
    }

    public function revisi(User $user) : bool {
        return $user->hasPermissionTo('Revision Permohonan');
    }

    public function revised(User $user) : bool {
        return $user->hasPermissionTo('Revised Permohonan');
    }

    public function review_revisi(User $user) : bool {
        return $user->hasPermissionTo('Review Perbaikan Permohonan');
    }

    public function confirm_revisi(User $user) : bool {
        return $user->hasPermissionTo('Confirm Perbaikan Permohonan');
    }

    public function viewAnyNphd(User $user) : bool {
        return $user->hasPermissionTo('View Any Nphd');
    }

    public function viewNphd(User $user) : bool {
        return $user->hasPermissionTo('View Nphd');
    }

    public function reviewNphd(User $user) : bool {
        return $user->hasPermissionTo('Review Nphd');
    }
    
}
