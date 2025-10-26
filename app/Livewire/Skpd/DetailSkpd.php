<?php

namespace App\Livewire\Skpd;

use App\Models\Skpd;
use App\Models\SkpdDetail;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

class DetailSkpd extends Component
{
    public $skpd;
    public $detail_skpd;

    public $nama_pimpinan;
    public $jabatan_pimpinan;
    public $nip_pimpinan;
    public $golongan_pimpinan;
    public $alamat_pimpinan;
    public $hp_pimpinan;
    public $email_pimpinan;
    
    public $nama_sekretaris;
    public $jabatan_sekretaris;
    public $nip_sekretaris;
    public $golongan_sekretaris;
    public $alamat_sekretaris;
    public $hp_sekretaris;
    public $email_sekretaris;

    public $perhatian_nphd;
    public $rekening_anggaran;

    public function mount($id_skpd = null){
        $this->skpd = Skpd::findOrFail($id_skpd);
        $this->detail_skpd = SkpdDetail::where('id_skpd', $id_skpd)->first();
        if($this->detail_skpd){
            $this->nama_pimpinan = $this->detail_skpd->nama_pimpinan;
            $this->jabatan_pimpinan = $this->detail_skpd->jabatan_pimpinan;
            $this->nip_pimpinan = $this->detail_skpd->nip_pimpinan;
            $this->golongan_pimpinan = $this->detail_skpd->golongan_pimpinan;
            $this->alamat_pimpinan = $this->detail_skpd->alamat_pimpinan;
            $this->hp_pimpinan = $this->detail_skpd->hp_pimpinan;
            $this->email_pimpinan = $this->detail_skpd->email_pimpinan;

            $this->nama_sekretaris = $this->detail_skpd->nama_sekretaris;
            $this->jabatan_sekretaris = $this->detail_skpd->jabatan_sekretaris;
            $this->nip_sekretaris = $this->detail_skpd->nip_sekretaris;
            $this->golongan_sekretaris = $this->detail_skpd->golongan_sekretaris;
            $this->alamat_sekretaris = $this->detail_skpd->alamat_sekretaris;
            $this->hp_sekretaris = $this->detail_skpd->hp_sekretaris;
            $this->email_sekretaris = $this->detail_skpd->email_sekretaris;

            $this->perhatian_nphd = $this->detail_skpd->perhatian_nphd;
            $this->rekening_anggaran = $this->detail_skpd->rekening_anggaran;
        }
    }

    #[Title('Detail SKPD')]
    public function render()
    {
        $detail = SkpdDetail::where('id', request()->id_skpd)->first();
        return view('livewire.skpd.detail-skpd', [
            'detail' => $detail
        ]);
    }

    public function simpan_pimpinan(){
        // $this->validate();
        DB::beginTransaction();
        try {
            $detail = SkpdDetail::updateOrCreate(
                ['id_skpd' => $this->skpd->id],
                [
                    'nama_pimpinan' => $this->nama_pimpinan,
                    'jabatan_pimpinan' => $this->jabatan_pimpinan,
                    'nip_pimpinan' => $this->nip_pimpinan,
                    'golongan_pimpinan' => $this->golongan_pimpinan,
                    'alamat_pimpinan' => $this->alamat_pimpinan,
                    'hp_pimpinan' => $this->hp_pimpinan,
                    'email_pimpinan' => $this->email_pimpinan,
                    ]
                );
                
            $detail['skpd'] = $this->skpd->name;

            ActivityLogService::log('skpd.update_pimpinan', 'warning', 'update data pimpinan ', json_encode($detail->toArray()));
            
            DB::commit();
    
            session()->flash('message', 'Data Pimpinan SKPD berhasil disimpan.');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan saat menyimpan data Pimpinan SKPD: ' . $th->getMessage());
        }
    }

    public function simpan_sekretaris(){
        // $this->validate();
        DB::beginTransaction();
        try {
            $detail = SkpdDetail::updateOrCreate(
                ['id_skpd' => $this->skpd->id],
                [
                    'nama_sekretaris' => $this->nama_sekretaris,
                    'jabatan_sekretaris' => $this->jabatan_sekretaris,
                    'nip_sekretaris' => $this->nip_sekretaris,
                    'golongan_sekretaris' => $this->golonganan_sekretaris,
                    'alamat_sekretaris' => $this->alamat_sekretaris,
                    'hp_sekretaris' => $this->hp_sekretaris,
                    'email_sekretaris' => $this->email_sekretaris,
                ]
            );

            $detail['skpd'] = $this->skpd->name;

            ActivityLogService::log('skpd.update_pimpinan', 'warning', 'update data pimpinan ', json_encode($detail->toArray()));
            
            DB::commit();
    
            session()->flash('message', 'Data Sekretaris SKPD berhasil disimpan.');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan saat menyimpan data Pimpinan SKPD: ' . $th->getMessage());
        }
    }
}
