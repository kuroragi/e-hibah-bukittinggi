<?php

namespace App\Livewire\Permohonan;

use App\Models\PendukungPermohonan;
use App\Models\Permohonan;
use App\Models\Status_permohonan;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class IsiPendukung extends Component
{
    use WithFileUploads;
    public $id_permohonan;
    #[Validate('required')]
    public $file_pernyataan_tanggung_jawab;
    #[Validate('required')]
    public $struktur_pengurus;
    #[Validate('required')]
    public $file_rab;
    #[Validate('required')]
    public $saldo_akhir_rek;
    #[Validate('required')]
    public $no_tidak_tumpang_tindih;
    #[Validate('required')]
    public $tanggal_tidak_tumpang_tindih;
    #[Validate('required')]
    public $file_tidak_tumpang_tindih;

    public $id_status_didukung;

    public function mount($id_permohonan = null){
        $this->id_permohonan = $id_permohonan;
        $this->id_status_didukung = Status_permohonan::where('name', 'Didukung')->first()->id;
    }

    public function render()
    {
        return view('livewire.permohonan.isi-pendukung');
    }

    public function store(){
        $this->validate();

        DB::beginTransaction();

        
            $ext_tanggung_jawab = $this->file_pernyataan_tanggung_jawab->getclientOriginalExtension();
            $tanggung_jawab_path = $this->file_pernyataan_tanggung_jawab->storeAs('dukung_permohonan', 'tanggung_jawab_'.Auth::user()->id.$this->id_permohonan.date('now').'.'.$ext_tanggung_jawab, 'public');

            $ext_pengurus = $this->struktur_pengurus->getclientOriginalExtension();
            $pengurus_path = $this->struktur_pengurus->storeAs('dukung_permohonan', 'pengurus_'.Auth::user()->id.$this->id_permohonan.date('now').'.'.$ext_pengurus, 'public');

            $ext_rab = $this->file_rab->getclientOriginalExtension();
            $rab_path = $this->file_rab->storeAs('dukung_permohonan', 'rab_'.Auth::user()->id.$this->id_permohonan.date('now').'.'.$ext_rab, 'public');

            $ext_saldo_akhir_rek = $this->saldo_akhir_rek->getclientOriginalExtension();
            $saldo_akhir_rek_path = $this->saldo_akhir_rek->storeAs('dukung_permohonan', 'saldo_akhir_rek_'.Auth::user()->id.$this->id_permohonan.date('now').'.'.$ext_saldo_akhir_rek, 'public');

            $ext_tidak_tumpang_tindih = $this->file_tidak_tumpang_tindih->getclientOriginalExtension();
            $tidak_tumpang_tindih_path = $this->file_tidak_tumpang_tindih->storeAs('dukung_permohonan', 'tidak_tumpang_tindih_'.Auth::user()->id.$this->id_permohonan.date('now').'.'.$ext_tidak_tumpang_tindih, 'public');

        try {
            $create_pendukung_permohonan = PendukungPermohonan::create([
                'id_permohonan' => $this->id_permohonan,
                'file_pernyataan_tanggung_jawab' => $tanggung_jawab_path,
                'struktur_pengurus' => $pengurus_path,
                'file_rab' => $rab_path,
                'saldo_akhir_rek' => $saldo_akhir_rek_path,
                'no_tidak_tumpang_tindih' => $this->no_tidak_tumpang_tindih,
                'tanggal_tidak_tumpang_tindih' => $this->tanggal_tidak_tumpang_tindih,
                'file_tidak_tumpang_tindih' => $tidak_tumpang_tindih_path,
            ]);

            Permohonan::findOrFail($this->id_permohonan)->update([
                'id_status' => $this->id_status_didukung
            ]);

            ActivityLogService::log('permohonan.create-pendukung', 'success', 'penambahan data pendukung permohonan', json_encode($create_pendukung_permohonan->toArray()));
            
            DB::commit();

            return redirect()->route('permohonan.isi_rab', ['id_permohonan' => $this->id_permohonan])->with('success', 'Berhasil menambahkan data pendukung, silahkan lanjutkan dengan mengisi data RAB!');
        } catch (\Throwable $th) {
            DB::rollBack();
            
            if(Storage::disk('public')->exists($tanggung_jawab_path)){
                Storage::disk('public')->delete($tanggung_jawab_path);
            }
            
            if(Storage::disk('public')->exists($pengurus_path)){
                Storage::disk('public')->delete($pengurus_path);
            }
            
            if(Storage::disk('public')->exists($rab_path)){
                Storage::disk('public')->delete($rab_path);
            }
            
            if(Storage::disk('public')->exists($saldo_akhir_rek_path)){
                Storage::disk('public')->delete($saldo_akhir_rek_path);
            }
            
            if(Storage::disk('public')->exists($tidak_tumpang_tindih_path)){
                Storage::disk('public')->delete($tidak_tumpang_tindih_path);
            }

            session()->flash('error', 'Gagal menyimpan data: ' . $th->getMessage());
        }

        
    }
}
