<?php

namespace App\Livewire\Permohonan;

use App\Models\PerbaikanProposal;
use App\Models\PerbaikanRab;
use App\Models\PerbaikanRincianRab;
use App\Models\Permohonan;
use App\Models\RabPermohonan;
use App\Models\RincianRab;
use App\Models\Satuan;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Perbaikan extends Component
{
    use WithFileUploads;
    public $permohonan;
    public $satuans;
    public $count_perbaikan = 0;

    #[Validate('required')]
    public $no_proposal;
    #[Validate('required')]
    public $tanggal_proposal;
    #[Validate('required')]
    public $judul_proposal;
    #[Validate('required')]
    public $file_proposal;
    #[Validate('required')]
    public $file_rab;

    public $nominal_rab;
    public $total_kegiatan = 0;
    public $kegiatans = [];
    #[Validate('required')]
    public $kegiatan_rab = [];
    public $rincian = [];
    
    public $listeners = ['close-modal'];
    
    public function mount($id_permohonan){
        $this->permohonan = Permohonan::with(['pendukung'])->where('id', $id_permohonan)->first();
        $this->nominal_rab = $this->permohonan->nominal_rab;
        $perbaikan_rab = PerbaikanRab::where('id_permohonan', $id_permohonan)->get();
        $this->count_perbaikan = $perbaikan_rab->count();
        if($this->count_perbaikan > 0){
        
            $this->kegiatans = PerbaikanRab::where('id_permohonan', $this->permohonan->id)->get();
            if($this->kegiatans){
                $grand = 0;
                foreach ($this->kegiatans as $k1 => $item) {
                    foreach ($item->rincian as $k2 => $child) {
                        $grand += $child->subtotal;
                    }
                }
                $this->total_kegiatan = $grand;
            }
            foreach ($this->kegiatans as $k1 => $item) {
                $this->kegiatan_rab[$k1] = [
                    'id_kegiatan' => $item->id,
                    'nama_kegiatan' => $item->nama_kegiatan,
                    'total_kegiatan' => $item->subtotal
                ];
            }
        }else{
        
            $this->kegiatans = RabPermohonan::where('id_permohonan', $this->permohonan->id)->get();
            if($this->kegiatans){
                $grand = 0;
                foreach ($this->kegiatans as $k1 => $item) {
                        $grand += $item->subtotal;
                }
                $this->total_kegiatan = $grand;
            }
            foreach ($this->kegiatans as $k1 => $item) {
                $this->kegiatan_rab[$k1] = [
                    'id_kegiatan' => $item->id,
                    'nama_kegiatan' => $item->nama_kegiatan,
                    'subtotal' => $item->subtotal
                ];
            }
        }
        $this->satuans = Satuan::orderBy('name')->get();
    }
    
    public function render()
    {
        return view('livewire.permohonan.perbaikan');
    }

    

    public function tambahKegiatan(){
        $countKegiatan = count($this->kegiatan_rab);
        $this->kegiatan_rab[$countKegiatan + 1] = [
            'name_kegiatan' => '',
            'total_kegiatan' => 0,
        ];
    }

    // public function tambahRincian($k1)
    // {
    //     $countChild = count($this->kegiatan_rab[$k1]['rincian']);
    //     $this->kegiatan_rab[$k1]['rincian'][$countChild + 1] = [
    //         'kegiatan' => '',
    //         'volume' => 0,
    //         'satuan' => '',
    //         'harga_satuan' => 0,
    //         'subtotal' => 0,
    //     ];
    // }

    public function deleteFormkegiatan($index){
        unset($this->kegiatan_rab[$index]);
        $this->kegiatan_rab = array_values($this->kegiatan_rab);
    }

    // public function hapusRincian($index)
    // {
    //     unset($this->rincian[$index]);
    //     $this->rincian = array_values($this->rincian); // reset index array
    // }

    // public function getSubtotal($k1, $k2)
    // {
    //     $child = $this->kegiatan_rab[$k1]['rincian'][$k2];
    //     $subtotal = (float) ($child['volume'] ?? 0) * (float) ($child['harga_satuan'] ?? 0);
    //     $this->kegiatan_rab[$k1]['rincian'][$k2]['subtotal'] = $subtotal;
    //     $this->kegiatan_rab[$k1]['total_kegiatan'] = $this->getTotalKegiatan($k1);
    //     return $subtotal;
    // }

    // Hitung total kegiatan
    // public function getTotalKegiatan($k1)
    // {
    //     $total = 0;
    //     foreach ($this->kegiatan_rab[$k1] as $k2 => $child) {

    //         $total += $child['subtotal'];
    //     }
    //     return $total;
    // }

    // Hitung total semua kegiatan
    public function getGrandTotal()
    {
        $grand = 0;
        foreach ($this->kegiatan_rab as $k1 => $item) {
            $grand += $item['subtotal'];
        }
        $this->total_kegiatan = $grand;
    }

    // public function hitungSubtotalBaris($index)
    // {
    //     if (isset($this->rincian[$index])) {
    //         $volume = floatval($this->rincian[$index]['volume'] ?? 0);
    //         $harga = floatval($this->rincian[$index]['harga_satuan'] ?? 0);
    //         $this->rincian[$index]['subtotal'] = $volume * $harga;
    //     }
    // }

    // public function hitungTotal()
    // {
    //     $this->total_kegiatan = collect($this->rincian)
    //         ->pluck('subtotal')
    //         ->filter(fn($val) => is_numeric($val))
    //         ->sum();
    // }

    public function update_rab(){
            $this->dispatch('close-modal');
            $this->getGrandTotal();
    }

    public function deleteKegiatan($id_kegiatan){
        $kegiatan = RabPermohonan::findOrFail($id_kegiatan);

        DB::beginTransaction();

        try {
    
            $kegiatan->delete();

            ActivityLogService::log('permohonan.rab.delete', 'danger', 'menghapus data kegiatan dan rincian pada RAB permohonan '.$this->permohonan->perihal_mohon, json_encode($kegiatan->toArray()));

            DB::commit();

            session()->flash('message', 'Kegiatan dan Semua Rincian telah berhasil di hapus');
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Kegiatan dan Rincian gagal dihapus :'.$th);
        }
    }

    public function checkRab(){
        if($this->total_kegiatan == $this->nominal_rab){
            return false;
        }else{
            return true;
        }
    }

    public function saveRevisi(){
        $this->validate();

        DB::beginTransaction();
        try {
            $perbaikanProposal = PerbaikanProposal::create([
                'id_permohonan' => $this->permohonan->id,
                'revision_number' => $this->count_perbaikan + 1,
                'no_proposal' => $this->no_proposal,
                'tanggal_perbaikan' => $this->tanggal_proposal,
                'judul_proposal' => $this->judul_proposal,
                'file_proposal' => $this->file_proposal->store('perbaikan_proposal', 'public'),
                'file_rab' => $this->file_rab->store('perbaikan_rab', 'public'),
            ]);

            foreach($this->kegiatan_rab as $k1 => $item){
                $kegiatan = PerbaikanRab::create([
                    'id_permohonan' => $this->permohonan->id,
                    'id_perbaikan' => 0,
                    'revision_number' => $this->count_perbaikan + 1,
                    'nama_kegiatan' => $this->kegiatan_rab[$k1]['nama_kegiatan'],
                    'subtotal' => $this->kegiatan_rab[$k1]['subtotal'],
                ]);
            }

            $this->permohonan->update([
                'nominal_anggaran' => $this->nominal_rab,
                'id_status' => 10,
            ]);

            $data = [
                'perbaikan_proposal' => json_encode($perbaikanProposal),
                'perbaikan_rab' => json_encode(PerbaikanRab::with(['rincian'])->where('id_permohonan', $this->permohonan->id)->get()->toArray()),
            ];
            
            ActivityLogService::log('permohonan.rab.update', 'warning', 'perbaikan pada RAB permohonan '.$this->permohonan->perihal_mohon, json_encode($data));

            DB::commit();

            session()->flash('message', 'Kegiatan dan Semua Rincian telah berhasil di hapus');

            return redirect()->route('permohonan');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            session()->flash('error', 'Kegiatan dan Rincian gagal dihapus :'.$th);
        }
    }
}
