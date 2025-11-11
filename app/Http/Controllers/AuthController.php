<?php

namespace App\Http\Controllers;

use App\Helpers\General;
use App\Mail\SendUserPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function login(){
        return view('pages.login');
    }

    public function Authenticate(Request $request){
        $validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        
        $credentials = [
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
        ];

        $remember = $request->boolean('remember');
        
        if(Auth::attempt($credentials, $remember)) {
            $regenerate = session()->regenerate();
            return redirect()->route('dashboard');
        }

        return redirect()->route('login')->withErrors(['email' => 'Email atau password yang anda masukan salah'])->onlyInput('email');
    }

    public function forgot_password(){
        return view('pages.forgot_password');
    }

    public function reset_password(Request $request){
        $user = User::where('email', $request->email)->first();

        if(!$user){
            return redirect()->route('auth.forgot_password')->with('danger', 'Email yang anda masukan tidak ditemukan');
        }

        DB::beginTransaction();

        try {
            $new_password = General::GeneratePassword(10);

            $user->update([
                'password' => Hash::make($new_password)
            ]);

            Mail::to($request->email)->queue(new SendUserPassword($new_password));

            DB::commit();

            return redirect()->route('login')->with('success', 'Berhasil memperbaharui password, silahkan lihat email anda!');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->route('auth.forgot_password')->with('danger', 'gagal ubah password karena: '.$th->getMessage());
        }
    }

    public function logout(Request $request){
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();
        
        return redirect()->route('login');
    }
}
