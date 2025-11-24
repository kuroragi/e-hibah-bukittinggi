<?php

namespace App\Http\Controllers;

use App\Models\Nphd;
use App\Models\Pencairan;
use App\Models\PerbaikanRab;
use App\Models\Permohonan;
use App\Models\RabPermohonan;
use App\Models\Skpd;
use App\Models\UrusanSkpd;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PermohonanController extends Controller
{
    public function index()
    {
        if(Auth::user()->hasRole('Super Admin')){
            $permohonan = Permohonan::whereBetween('id_status', [1,12])->get();
        }

        if(Auth::user()->hasRole('Admin SKPD')){
            $permohonan = Permohonan::with(['skpd', 'lembaga'])->where('id_skpd', Auth::user()->id_skpd)->whereBetween('id_status', [1,12])->get();
        }

        if(Auth::user()->hasRole('Reviewer') || Auth::user()->hasRole('Verifikator')){
            $permohonan = Permohonan::with(['skpd', 'lembaga'])->where('id_skpd', Auth::user()->id_skpd)->where('urusan', Auth::user()->id_urusan)->whereBetween('id_status', [1,12])->get();
        }
        
        if(Auth::user()->hasRole('Admin Lembaga')){
            $permohonan = Permohonan::with(['skpd', 'lembaga'])->where('id_lembaga', Auth::user()->id_lembaga)->whereBetween('id_status', [1,12])->get();
        }

        // Logic to retrieve and display permohonan information
        return view('pages.permohonan.index', [
            'permohonan' => $permohonan,
        ]);
    }

    public function show($id_permohonan){
        $permohonan = Permohonan::with(['lembaga', 'skpd', 'status', 'pendukung', 'perbaikanProposal.perbaikan_rab'])->where('id', $id_permohonan)->first();
        $kegiatans = PerbaikanRab::where('id_permohonan', $id_permohonan)->latest()->get();
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
        $permohonan = Permohonan::where('id', $id_permohonan)->first();
        $permohonan->update([
            'id_status' => 4,
        ]);

        ActivityLogService::log('permohonan.send', 'info', 'lembaga mengirim data permohonan', json_encode($permohonan->toArray()));

        return redirect()->route('permohonan');
    }

    public function downloadPermohonan($id_permohonan){
        $permohonan = Permohonan::findOrFail($id_permohonan);
    }

    public function send_review($id_permohonan){
        $permohonan = Permohonan::where('id', $id_permohonan)->first();
        $permohonan->increment('id_status');

        ActivityLogService::log('permohonan.send_result', 'info', 'kirim data hasil review', json_encode($permohonan->toArray()));

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
        DB::beginTransaction();
        try {
            $permohonan = tap(Permohonan::findOrFail($id_permohonan))->update([
                'id_status' => 11,
            ]);

            ActivityLogService::log('permohonan.send_revision', 'info', 'kirim data revisi', json_encode($permohonan->only([
                'id',
                'no_mohon',
                'perihal_mohon',
                'id_status',
            ])));
            
            DB::commit();
            return redirect()->route('permohonan');
        } catch (\Throwable $th) {
            DB::rollBack();

            session()->flash('error', 'Gagal Mengirim data permohonan yang telah di perbaiki: '.$th->getMessage());
        }
    }

    public function pencairan(){
        if(Auth::user()->hasRole('Super Admin')){
            $permohonan = Permohonan::with(['skpd', 'lembaga', 'nphd'])->where('id_status', 14)->get();
        }

        if(Auth::user()->hasRole('Admin SKPD')){
            $permohonan = Permohonan::with(['skpd', 'lembaga', 'nphd'])->where('id_skpd', Auth::user()->id_skpd)->where('id_status', 14)->get();
        }

        if(Auth::user()->hasRole('Reviewer') || Auth::user()->hasRole('Verifikator')){
            $permohonan = Permohonan::with(['skpd', 'lembaga', 'nphd'])->where('id_skpd', Auth::user()->id_skpd)->where('urusan', Auth::user()->id_urusan)->where('id_status', 14)->get();
        }
        
        if(Auth::user()->hasRole('Admin Lembaga')){
            $permohonan = Permohonan::with(['skpd', 'lembaga', 'nphd'])->where('id_lembaga', Auth::user()->id_lembaga)->where('id_status', 14)->get();
        }
        return view('pages.permohonan.pencairan',[
            'permohonan' => $permohonan,
        ]);
    }

    public function uploadNphd(Request $request){
        $validatedData = $request->validate([
            'no_nphd_skpd' => 'required',
            'no_nphd_lembaga' => 'required',
            'tanggal_nphd' => 'required',
            'file_nphd' => 'required|mimetypes:application/pdf',
            'nilai_disetujui' => 'required',
            'no_permohonan' => 'required',
            'tanggal_permohonan' => 'required',
            'file_permohonan' => 'required|mimetypes:application/pdf',
        ]);

        $permohonan = Permohonan::findOrFail($request->id_permohonan);


        DB::beginTransaction();
        $nphd_ext = $request->file_nphd->getclientOriginalExtension();
        $nphd_path = $request->file_nphd->storeAs('nphd', 'nphd_'.$permohonan->id.$permohonan->tahun_apbd.'.'.$nphd_ext, 'public');
        
        $permohonan_ext = $request->file_permohonan->getclientOriginalExtension();
        $permohonan_path = $request->file_permohonan->storeAs('nphd', 'permohonan_pencairan_'.$permohonan->id.$permohonan->tahun_apbd.'.'.$permohonan_ext, 'public');
        try {
            $nphd = Nphd::create([
                'id_permohonan' => $permohonan->id,
                'file_nphd' => $nphd_path,
                'no_nphd' => $request->no_nphd,
                'tanggal_nphd' => $request->tanggal_nphd,
                'nilai_disetujui' => $request->nilai_disetujui,
                'no_permohonan' => $request->no_permohonan,
                'tanggal_permohonan' => $request->tanggal_permohonan,
                'file_permohonan' => $permohonan_path,
            ]);

            ActivityLogService::log('nphd.upload', 'warning', 'upload data dan file NPHD '.$permohonan->perihal_mohon, json_encode($nphd->toArray()));

            DB::commit();

            return redirect()->route('pencairan')->with('success', 'Berhasil upload NPHD, menunggu pencairan!');
        } catch (\Throwable $th) {
            DB::rollBack();
            
            if(Storage::disk('public')->exists($nphd_path)){
                Storage::disk('public')->delete($nphd_path);
            }

            return redirect()->route('pencairan')->withInput()->with('error', 'Terjadi kesalahan: '.$th->getMessage());
        }
    }

    public function cekPendukung($id_permohonan){
        $permohonan = Permohonan::with(['lembaga', 'skpd', 'status', 'pendukung', 'nphd'])->where('id', $id_permohonan)->first();
        return view('pages.permohonan.cek_pencairan', [
            'permohonan' => $permohonan,
        ]);
    }

    public function showPencairan($id_pencairan){
        $pencairan = Pencairan::with([
            'permohonan.lembaga.bank',
            'permohonan.skpd',
            'verifier',
            'approver'
        ])->findOrFail($id_pencairan);

        // Check authorization
        $user = Auth::user();
        if ($user->hasRole('Admin Lembaga')) {
            if ($pencairan->permohonan->id_lembaga != $user->id_lembaga) {
                abort(403, 'Unauthorized access');
            }
        }

        return view('livewire.pencairan.show-pencairan', [
            'pencairan' => $pencairan,
        ]);
    }
}
