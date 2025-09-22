<?php

namespace App\Livewire\Pages;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserGuide extends Component
{
    public $userGuide;

    public function mount(){
        if(Auth::user()->hasRole('Admin Lembaga')){
            $this->userGuide = 'assets/documentation/user_guide/user_guide_admin_lembaga.pdf';
        }
        if(Auth::user()->hasRole('Reviewer')){
            $this->userGuide = 'assets/documentation/user_guide/user_guide_reviewer_verifikator.pdf';
        }
        if(Auth::user()->hasRole('Verifikator')){
            $this->userGuide = 'assets/documentation/user_guide/user_guide_reviewer_verifikator.pdf';
        }
        if(Auth::user()->hasRole('Super Admin')){
            $this->userGuide = 'assets/documentation/user_guide/user_guide_super_admin.pdf';
        }
    }

    public function render()
    {
        return view('livewire.pages.user-guide');
    }
}
