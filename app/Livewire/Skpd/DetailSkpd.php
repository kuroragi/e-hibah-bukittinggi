<?php

namespace App\Livewire\Skpd;

use App\Models\Skpd;
use App\Models\SkpdDetail;
use App\Models\UrusanSkpd;
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
    // public $jabatan_sekretaris;
    // public $nip_sekretaris;
    // public $golongan_sekretaris;
    // public $alamat_sekretaris;
    // public $hp_sekretaris;
    // public $email_sekretaris;

    public $urusans = [];

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
            // $this->jabatan_sekretaris = $this->detail_skpd->jabatan_sekretaris;
            // $this->nip_sekretaris = $this->detail_skpd->nip_sekretaris;
            // $this->golongan_sekretaris = $this->detail_skpd->golongan_sekretaris;
            // $this->alamat_sekretaris = $this->detail_skpd->alamat_sekretaris;
            // $this->hp_sekretaris = $this->detail_skpd->hp_sekretaris;
            // $this->email_sekretaris = $this->detail_skpd->email_sekretaris;

            $urusans = $this->skpd->has_urusan()->get();
            foreach ($urusans as $key => $urusan) {
                $this->urusans[] = [
                    'id' => $urusan->id,
                    'nama_urusan' => $urusan->nama_urusan,
                    'kepala_urusan' => $urusan->kepala_urusan,
                    'kegiatan' => $urusan->kegiatan ? 
                            json_decode($urusan->kegiatan) : 
                            [0 => ['nama_kegiatan' => '', 'sub_kegiatan' => [0 => ['nama_sub_kegiatan' => '', 'rekening_anggaran' => [0 => ['rekening' => '']]]]]]
                    // 'kegiatan' => $urusan->kegiatan,
                    // 'sub_kegiatan' => $urusan->sub_kegiatan,
                    // 'rekening_anggaran' => $urusan->sub_kegiatan ? json_decode($urusan->sub_kegiatan) : [0 => ['rekening' => '']],
                ];
                // if($urusan->rekening_anggaran == null || $urusan->rekening_anggaran == ''){
                //     $this->urusans[$key]['rekening_anggaran'][] = ['rekening' => ''];
                // }else{
                //     $this->urusans[$key]['rekening_anggaran'][] = json_decode($urusan->rekening_anggaran);
                // }
            }

            $this->perhatian_nphd = $this->detail_skpd->perhatian_nphd ? json_decode($this->detail_skpd->perhatian_nphd, true) : [0 => ['uraian' => '', 'urusan' => 0]];
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
                    'nama_sekretaris' => $this->nama_sekretaris,
                    ]
                );
                
                foreach ($this->urusans as $key => $item) {
                    $urusan = tap(UrusanSkpd::findOrFail($item['id']))->update([
                        'kepala_urusan' => $item['kepala_urusan'],
                    ]);
                }
                
                $detail['skpd'] = $this->skpd->name;
                $detail['urusan_skpd'] = $this->urusans;
                
                ActivityLogService::log('skpd.update_pimpinan', 'warning', 'update data pimpinan ', json_encode($detail->toArray()));
            
            DB::commit();
    
            session()->flash('success', 'Data Pimpinan dan saksi SKPD berhasil disimpan.');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan saat menyimpan data Pimpinan SKPD atau saksi: ' . $th->getMessage());
        }
    }

    // kegiatan
    public function tambahKegiatan($index1){
        $indexKegiatan = count($this->urusans[$index1]['kegiatan']) - 1;
        $this->urusans[$index1]['kegiatan'][$indexKegiatan + 1] = ['nama_kegiatan' => '', 'sub_kegiatan' => [0 => ['nama_sub_kegiatan' => '', 'rekening_anggaran' => [0 => ['rekening' => '']]]]];
    }

    public function hapusKegiatan($index1, $index2){
        unset($this->urusans[$index1]['kegiatan'][$index2]);
        $this->urusans = array_values($this->urusans);
    }
    // end kegiatan

    // Subkegiatan
    public function tambahSubkegiatan($index1, $index2){
        $indexSubkegiatan = count($this->urusans[$index1]['kegiatan'][$index2]['sub_kegiatan']) - 1;
        $this->urusans[$index1]['kegiatan'][$index2]['sub_kegiatan'][$indexSubkegiatan + 1] = ['nama_sub_kegiatan' => '', 'rekening_anggaran' => [0 => ['rekening' => '']]];
    }

    public function hapusSubkegiatan($index1, $index2, $index3){
        unset($this->urusans[$index1]['kegiatan'][$index2]['sub_kegiatan'][$index3]);
        $this->urusans = array_values($this->urusans);
    }
    // end Subkegiatan

    // rekening
    public function tambahRekening($index1, $index2, $index3){
        $indexRekening = count($this->urusans[$index1]['kegiatan'][$index2]['sub_kegiatan'][$index3]['rekening_anggaran']) - 1;
        $this->urusans[$index1]['kegiatan'][$index2]['sub_kegiatan'][$index3]['rekening_anggaran'][$indexRekening + 1] = ['rekening' => ''];
    }

    public function hapusRekening($index1, $index2, $index3, $index4){
        unset($this->urusans[$index1]['kegiatan'][$index2]['sub_kegiatan'][$index3]['rekening_anggaran'][$index4]);
        $this->urusans = array_values($this->urusans);
    }
    // rekening

    public function updateUrusan(){
        DB::beginTransaction();
        try {
            foreach ($this->urusans as $key => $item) {
                $urusan = UrusanSkpd::updateOrCreate([
                    'id' => $item['id']
                ], [
                    'kegiatan' => json_encode($item['kegiatan'])
                ]);
            }
            DB::commit();
            session()->flash('warning', 'Berhasil memperbarui data urusan terkait NPHD');
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan saat menyimpan data urusan terkait NPHD: ' . $th->getMessage());
        }
    }

    public function tambahPerhatian(){
        $indexPerhatian = count($this->perhatian_nphd) - 1;
        $this->perhatian_nphd[$indexPerhatian + 1] = ['uraian' => '', 'urusan' => 0];
    }

    public function hapusPerhatian($index){
        unset($this->perhatian_nphd[$index]);
        $this->perhatian_nphd = array_values($this->perhatian_nphd);
    }

    public function updatePerhatian(){
        DB::beginTransaction();
        try {
            $perhatian = SkpdDetail::updateOrCreate([
                'id_skpd' => $this->skpd->id
            ], [
                'perhatian_nphd' => json_encode($this->perhatian_nphd)
            ]);

            ActivityLogService::log('skpd.update_perhatian_nphd', 'warning', 'update data perhatian dalam NPHD ', json_encode($perhatian->toArray()));

            DB::commit();
            session()->flash('warning', 'Berhasil memperbarui data yang menjadi perhatian dalam NPHD');
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan saat menyimpan data yang menjadi perhatian dalam NPHD: ' . $th->getMessage());
        }
    }
}
