<?php

namespace App\Traits;

use Illuminate\Auth\Access\AuthorizationException;

trait WithAuthorization
{
    
    public function authorizeAction(string $ability, $arguments = [])
    {
        try {
            $this->authorize($ability, $arguments); // langsung pakai authorize bawaan Laravel
        } catch (AuthorizationException $e) {
            return redirect()->route('dashboard')
                ->with('no_access', 'Kamu tidak memiliki hak akses ke halaman tersebut.');
        }

        return false;
    }
}