<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ChangePassword extends Component
{
    public $id_user;

    public $current_password;
    public $password;
    public $password_confirmation;

    protected $listeners = ['confirm_password'];

    public function mount(){
        $this->id_user = Auth::user()->id;
    }

    public function render()
    {
        return view('livewire.user.change-password');
    }

    public $rulesStatus = [
        'min_length' => false,
        'uppercase' => false,
        'lowercase' => false,
        'number' => false,
        'symbol' => false,
        'match' => false,
    ];

    public function updatedPassword($value)
    {
        $this->rulesStatus['min_length'] = strlen($value) >= 8;
        $this->rulesStatus['uppercase']  = preg_match('/[A-Z]/', $value);
        $this->rulesStatus['lowercase']  = preg_match('/[a-z]/', $value);
        $this->rulesStatus['number']     = preg_match('/[0-9]/', $value);
        $this->rulesStatus['symbol']     = preg_match('/[\W_]/', $value);

        $this->rulesStatus['match'] = $value === $this->password_confirmation;
    }

    public function updatedPasswordConfirmation($value)
    {
        $this->rulesStatus['match'] = $this->password === $value;
    }

    public function update(){
        
        $this->validate([
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',   // huruf besar
                'regex:/[a-z]/',   // huruf kecil
                'regex:/[0-9]/',   // angka
                'regex:/[\W_]/',   // simbol
                'confirmed',
            ],
        ], [
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan simbol.',
        ]);

        if (!Hash::check($this->current_password, Auth::user()->password)) {
            return session()->flash('error', 'Password lama salah.');
        }

        auth()->user()->update([
            'password' => Hash::make($this->password),
        ]);

        session()->flash('success', 'Password berhasil diperbarui.');
        $this->reset(['current_password', 'password', 'password_confirmation']);
    }
}
