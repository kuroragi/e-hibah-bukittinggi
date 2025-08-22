<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NphdContoller extends Controller
{
    public function index(){
        if(Auth::user()->hasRole('Super Admin')){
            $permohonan = Permohonan::with(['skpd', 'lembaga'])->where('id_status', 7)->get();
        }

        if(Auth::user()->hasRole('Admin SKPD')){
            $permohonan = Permohonan::with(['skpd', 'lembaga'])->where('id_skpd', Auth::user()->id_skpd)->where('id_status', 7)->get();
        }

        if(Auth::user()->hasRole('Reviewer') || Auth::user()->hasRole('Verifikator')){
            $permohonan = Permohonan::with(['skpd', 'lembaga'])->where('id_skpd', Auth::user()->id_skpd)->where('urusan', Auth::user()->id_urusan)->where('id_status', 7)->get();
        }
        
        if(Auth::user()->hasRole('Admin Lembaga')){
            $permohonan = Permohonan::with(['skpd', 'lembaga'])->where('id_lembaga', Auth::user()->id_lembaga)->where('id_status', 7)->get();
        }
        
        return view('pages.nphd.index', [
            'permohonan' => $permohonan
        ]);
    }
}
