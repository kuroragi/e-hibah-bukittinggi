<?php

namespace App\Livewire\Skpd;

use App\Models\Skpd;
use App\Models\SkpdDetail;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;

class DetailSkpd extends Component
{
    public $skpd;

    public $nama_pimpinan;
    public $jabatan;
    public $alamat_pimpinan;
    public $hp_pimpinan;
    public $email_pimpinan;
    public $perhatian_nphd;
    public $rekening_anggaran;

    public function mount($id_skpd = null){
        $this->skpd = Skpd::findOrFail($id_skpd);
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
                    'jabatan' => $this->jabatan,
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
}
