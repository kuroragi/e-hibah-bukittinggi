<?php

namespace App\Http\Controllers;

use App\Models\Lembaga;
use App\Models\Permohonan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function dasboard(){
        $user = User::all();
        $yearNow = date('2026'); // contoh: 2025
        $yearStart = $yearNow - 4; // 2021
        if(Auth::user()->hasRole('Super Admin')){
            $permohonan = Permohonan::all();
            $dataPerTahun = Permohonan::selectRaw('tahun_apbd, ROUND(SUM(nominal_anggaran) / 1000000, 1) as total')
                ->whereBetween('tahun_apbd', [$yearStart, $yearNow])
                ->groupBy('tahun_apbd')
                ->orderBy('tahun_apbd')
                ->pluck('total', 'tahun_apbd');
        }else if(Auth::user()->hasRole('Admin Lembaga')){
            $permohonan = Permohonan::where('id_lembaga', Auth::user()->id_lembaga)->get();
            $dataPerTahun = Permohonan::selectRaw('tahun_apbd, ROUND(SUM(nominal_anggaran) / 1000000, 1) as total')
                ->whereBetween('tahun_apbd', [$yearStart, $yearNow])
                ->where('id_lembaga', Auth::user()->id_lembaga)
                ->groupBy('tahun_apbd')
                ->orderBy('tahun_apbd')
                ->pluck('total', 'tahun_apbd');
        }else{
            $permohonan = Permohonan::where('id_skpd', Auth::user()->id_skpd)->get();
            $dataPerTahun = Permohonan::selectRaw('tahun_apbd, ROUND(SUM(nominal_anggaran) / 1000000, 1) as total')
                ->whereBetween('tahun_apbd', [$yearStart, $yearNow])
                ->where('id_skpd', Auth::user()->id_skpd)
                ->groupBy('tahun_apbd')
                ->orderBy('tahun_apbd')
                ->pluck('total', 'tahun_apbd');
        }
        $lembaga = Lembaga::all();
            
        $years = collect(range($yearStart, $yearNow));
        $pencairan = $years->mapWithKeys(fn($year) => [$year => $dataPerTahun->get($year, 0)]);
        return view('pages.dashboard', [
            'permohonan' => $permohonan,
            'user' => $user,
            'lembaga' => $lembaga,
            'pencairan' => $pencairan,
        ]);
    }

    public function permission(){
        return view('pages.permission');
    }

    public function role(){
        return view('pages.role');
    }
}
