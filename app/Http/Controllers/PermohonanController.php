<?php

namespace App\Http\Controllers;

use App\Models\PerbaikanRab;
use App\Models\Permohonan;
use App\Models\RabPermohonan;
use App\Models\Skpd;
use App\Models\UrusanSkpd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermohonanController extends Controller
{
    public function index()
    {
        if(Auth::user()->hasRole('Super Admin')){
            $permohonan = Permohonan::all();
        }

        if(Auth::user()->hasRole('Admin SKPD')){
            $permohonan = Permohonan::with(['skpd', 'lembaga'])->where('id_skpd', Auth::user()->id_skpd)->get();
        }

        if(Auth::user()->hasRole('Reviewer') || Auth::user()->hasRole('Verifikator')){
            $permohonan = Permohonan::with(['skpd', 'lembaga'])->where('id_skpd', Auth::user()->id_skpd)->where('urusan', Auth::user()->id_urusan)->get();
        }
        
        if(Auth::user()->hasRole('Admin Lembaga')){
            $permohonan = Permohonan::with(['skpd', 'lembaga'])->where('id_lembaga', Auth::user()->id_lembaga)->get();
        }

        // Logic to retrieve and display permohonan information
        return view('pages.permohonan.index', [
            'permohonan' => $permohonan,
        ]);
    }

    public function show($id_permohonan){
        $permohonan = Permohonan::with(['lembaga', 'skpd', 'status', 'pendukung', 'perbaikanProposal.perbaikan_rab.rincian'])->where('id', $id_permohonan)->first();
        $kegiatans = PerbaikanRab::with(['rincian.satuan'])->where('id_permohonan', $id_permohonan)->latest()->get();
        if(!$kegiatans->count() > 0){
            $kegiatans = RabPermohonan::with(['rincian.satuan'])->where('id_permohonan', $id_permohonan)->get();
        }
        $skpds = Skpd::all();
        $urusans = UrusanSkpd::where('id_skpd', $permohonan->id_skpd)->get();
        return view('pages.permohonan.show', [
            'permohonan' => $permohonan,
            'kegiatans' => $kegiatans,
            'skpds' => $skpds,
            'urusans' => $urusans,
        ]);
    }

    public function send($id_permohonan){
        Permohonan::where('id', $id_permohonan)->update([
            'id_status' => 4,
        ]);

        return redirect()->route('permohonan');
    }

    public function downloadPermohonan($id_permohonan){
        $permohonan = Permohonan::findOrFail($id_permohonan);
        dd($permohonan);
    }

    public function send_review($id_permohonan){
        Permohonan::where('id', $id_permohonan)->increment('id_status');

        return redirect()->route('permohonan');
    }

    public function confirm_review() {
        //
    }

    public function donwload_pemberitahuan($id_permohonan){
        // $permohonan = Permohonan::findOrFail($id_permohonan);

        // $path = storage_path('app/public/'.$permohonan->file_pemberitahuan);

        // if (!file_exists($path)) {
        //     abort(404, 'File tidak ditemukan.');
        // }

        // return response()->download($path, $permohonan->file_pemberitahuan);
        return redirect()->route('nphd');
;    }

    public function send_revisi($id_permohonan){
        Permohonan::where('id', $id_permohonan)->update([
            'id_status' => 11,
        ]);

        return redirect()->route('permohonan');
    }
}
