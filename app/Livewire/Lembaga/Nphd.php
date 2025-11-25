<?php

namespace App\Livewire\Lembaga;

use App\Models\Lembaga;
use App\Models\NphdLembaga;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Nphd extends Component
{
    public $lembaga;
    public $nphd;
    
    public $nomor_pengukuhan;
    public $tanggal_pengukuhan;
    public $tentang_pengukuhan;
    public $pemberi_amanat;
    public $masa_bakti;
    public $deskripsi;
    public $uraian = [];

    public function mount($id_lembaga){
        $this->lembaga = Lembaga::findOrFail($id_lembaga);
        $this->nphd = $this->lembaga->nphdLembaga;
        $this->nphd ? '' : $this->nphd = NphdLembaga::create(['id_lembaga' => $this->lembaga->id]);
        if($this->nphd){
            $this->nomor_pengukuhan = $this->nphd->nomor_pengukuhan;
            $this->tanggal_pengukuhan = $this->nphd->tanggal_pengukuhan;
            $this->tentang_pengukuhan = $this->nphd->tentang_pengukuhan;
            $this->pemberi_amanat = $this->nphd->pemberi_amanat;
            $this->masa_bakti = $this->nphd->masa_bakti;
            $this->deskripsi = $this->nphd->deskripsi;
            $this->uraian = json_decode($this->nphd->uraian, true);
        }
        if($this->uraian == null || count($this->uraian) == 0){
            $this->uraian = [
                [
                    'uraian' => ''
                ]
            ];
        }
    }

    public function render()
    {
        return view('livewire.lembaga.nphd');
    }

    public function tambahUraian(){
        $index_uraian = count($this->uraian) - 1;
        $this->uraian[$index_uraian + 1] = [
            'uraian' => ''
        ];
    }

    public function haspusUraian($index){
        unset($this->uraian[$index]);
        $this->uraian = array_values($this->uraian);
    }

    public function updateKonfigurasi(){
        $validatedData = $this->validate([
            'nomor_pengukuhan' => 'required|string|max:255',
            'tanggal_pengukuhan' => 'required|date',
            'tentang_pengukuhan' => 'required|string|max:255',
            'pemberi_amanat' => 'required|string|max:255',
            'masa_bakti' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'uraian' => 'nullable',
        ],[
            'nomor_pengukuhan.required' => 'Nomor Pengukuhan wajib diisi',
            'tanggal_pengukuhan.required' => 'Tanggal Pengukuhan wajib diisi',
            'tentang_pengukuhan.required' => 'Tentang Pengukuhan wajib diisi',
            'pemberi_amanat.required' => 'Pemberi Amanat wajib diisi',
            'masa_bakti.required' => 'Masa Bakti wajib diisi',
            'deskripsi.required' => 'Deskripsi wajib diisi',]);
        $validatedData['uraian'] = json_encode($this->uraian);

        DB::beginTransaction();
        try{
            $nphdConf = tap($this->nphd)->update($validatedData);
            
            ActivityLogService::log('lembaga.update-konfigurasi-nphd', 'warning', 'pembaruan data Konfigurasi NPHD '.$this->lembaga->name, json_encode($nphdConf->toArray()));
            DB::commit();

            session()->flash('success', 'Konfigurasi NPHD berhasil diperbarui.');
        }catch(\Exception $e){
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan saat memperbarui Konfigurasi NPHD: ' . $e->getMessage());
        }
    }
}
