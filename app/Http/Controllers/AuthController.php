<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function Authenticate(){
        if(Auth::check()){
            return redirect()->route('dashboard');
        }

        return view('welcome');
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect()->route('login');
    }
}
