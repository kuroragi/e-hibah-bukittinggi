<?php

namespace App\Livewire\Permohonan;

use App\Models\Permohonan;
use App\Models\RabPermohonan;
use App\Models\RincianRab;
use App\Models\Satuan;
use App\Models\Status_permohonan;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class IsiRab extends Component
{
    public $permohonan;
    public $satuans;
    public $kegiatans;
    public $nominal_rab;

    // #[Validate('required')]
    public $nama_kegiatan;
    public $total_pengajuan;
    public $total_kegiatan;

    #[Validate('required')]
    public $kegiatan_rab = [];

    public $id_status_didraft;

    // #[Validate('required')]
    public $rincian = [];

    public $listeners = ['updateSubTotal', 'close-modal'];

    public function mount($id_permohonan = null){
        $this->permohonan = Permohonan::findOrFail($id_permohonan);
        $this->satuans = Satuan::orderBy('name')->get();
        $this->id_status_didraft = Status_permohonan::where('name', 'draft')->first()->id;
    }

    public function render()
    {
        $this->kegiatans = RabPermohonan::where('id_permohonan', $this->permohonan->id)->get();
        $grand = 0;
        if($this->kegiatans){
            foreach ($this->kegiatans as $k1 => $item) {
                $grand += $item->subtotal;
            }
            $this->total_kegiatan = $grand;
        }
        return view('livewire.permohonan.isi-rab');
    }

    public function tambahKegiatan(){
        $indexKegiatan = count($this->kegiatan_rab) - 1;
        $this->kegiatan_rab[$indexKegiatan + 1] = [
            'name_kegiatan' => '',
            'total_kegiatan' => '',
        ];
    }

    // rincian kegiatan dihapus
    /*
    public function tambahRincian($k1)
    {
        $countChild = count($this->kegiatan_rab[$k1]['rincian']);
        $this->kegiatan_rab[$k1]['rincian'][$countChild + 1] = [
            'kegiatan' => '',
            'volume' => 0,
            'satuan' => '',
            'harga_satuan' => 0,
            'subtotal' => 0,
        ];
    }

    public function hapusRincian($index)
    {
        unset($this->rincian[$index]);
        $this->rincian = array_values($this->rincian); // reset index array
    }

    public function getSubtotal($k1, $k2)
    {
        $child = $this->kegiatan_rab[$k1]['rincian'][$k2];
        $subtotal = (float) ($child['volume'] ?? 0) * (float) ($child['harga_satuan'] ?? 0);
        $this->kegiatan_rab[$k1]['rincian'][$k2]['subtotal'] = $subtotal;
        $this->kegiatan_rab[$k1]['total_kegiatan'] = $this->getTotalKegiatan($k1);
        return $subtotal;
    }

    // Hitung total kegiatan
    public function getTotalKegiatan($k1)
    {
        $total = 0;
        foreach ($this->kegiatan_rab[$k1]['rincian'] as $k2 => $child) {

            $total += $child['subtotal'];
        }
        return $total;
    }

    public function updated($property)
    {
        if (
            str_starts_with($property, 'rincian.') &&
            (str_ends_with($property, '.volume') || str_ends_with($property, '.harga_satuan'))
        ) {
            // Dapatkan index baris dari properti yang berubah
            $pattern = '/rincian\.(\d+)\./'; // contoh: rincian.2.volume
            if (preg_match($pattern, $property, $matches)) {
                $index = (int)$matches[1];
                $this->hitungSubtotalBaris($index);
            }

            // Tetap hitung total seluruh subtotal
            $this->hitungTotal();
        }
    }

    public function hitungSubtotalBaris($index)
    {
        if (isset($this->rincian[$index])) {
            $volume = floatval($this->rincian[$index]['volume'] ?? 0);
            $harga = floatval($this->rincian[$index]['harga_satuan'] ?? 0);
            $this->rincian[$index]['subtotal'] = $volume * $harga;
        }
    }

    public function hitungTotal()
    {
        $this->total_kegiatan = collect($this->rincian)
            ->pluck('subtotal')
            ->filter(fn($val) => is_numeric($val))
            ->sum();
    }
    */

    // Hitung total semua kegiatan
    public function getGrandTotal()
    {
        $grand = 0;
        foreach ($this->kegiatan_rab as $k1 => $item) {
            $grand += $this->getTotalKegiatan($k1);
        }
        $this->total_kegiatan = $grand;
    }

    public function deleteFormkegiatan($index){
        unset($this->kegiatan_rab[$index]);
        $this->kegiatan_rab = array_values($this->kegiatan_rab); // reset index array
    }

    public function store(){
        $this->validate();
        
        DB::beginTransaction();
        try {
            foreach($this->kegiatan_rab as $k1 => $item){
                $kegiatan = RabPermohonan::create([
                    'id_permohonan' => $this->permohonan->id,
                    'nama_kegiatan' => $item['name_kegiatan'],
                    'subtotal' => $item['total_kegiatan'],
                ]);

                /*
                foreach($this->kegiatan_rab[$k1]['rincian'] as $k2 => $rincian){
                    RincianRab::create([
                        'id_rab' => $kegiatan->id,
                        'keterangan' => $rincian['kegiatan'],
                        'volume' => $rincian['volume'],
                        'id_satuan' => $rincian['satuan'],
                        'harga' => $rincian['harga_satuan'],
                        'subtotal' => $rincian['subtotal'],
                    ]);
                }
                */
            }

            ActivityLogService::log('permohonan.create-rab', 'success', 'penambahan data RAB '.$this->permohonan->perihal_mohon, json_encode($this->kegiatan_rab));

            DB::commit();
            $this->reset(['kegiatan_rab']);
            $this->dispatch('close-modal');
            $this->getGrandTotal();
        } catch (\Throwable $th) {
            DB::rollBack();
            
            session()->flash('error', 'Kegiatan dan Rincian gagal dihapus :'.$th);
        }

    }

    public function deleteKegiatan($id_kegiatan){
        $kegiatan = RabPermohonan::findOrFail($id_kegiatan);

        DB::beginTransaction();

        try {
    
            $kegiatan->delete();

            DB::commit();

            session()->flash('message', 'Kegiatan dan Semua Rincian telah berhasil di hapus');
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Kegiatan dan Rincian gagal dihapus :'.$th);
        }
    }

    public function checkPengajuan(){
        if($this->total_kegiatan == $this->total_pengajuan){
            return false;
        }else{
            return true;
        }
    }

    public function saveRab(){
        $rab = $this->permohonan->update([
            'nominal_rab' => $this->total_pengajuan,
            'id_status' => $this->id_status_didraft,
        ]);

        ActivityLogService::log('permohonan.save-rab', 'info', 'Save RAB '.$this->permohonan->perihal_mohon, json_encode($this->rab->toArray()));

        return redirect()->route('permohonan');
    }
}
