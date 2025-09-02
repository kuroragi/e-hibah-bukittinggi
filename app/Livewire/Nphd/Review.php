<?php

namespace App\Livewire\Nphd;

use App\Models\PerbaikanRab;
use App\Models\Permohonan;
use App\Models\RabPermohonan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Review extends Component
{
    public $permohonan;

    public $step = 1;
    
    public $nominal_anggaran;
    public $total_kegiatan = 0;
    public $kegiatans = [];
    public $kegiatan_rab = [];

    public $file_nphd;

    public function mount($id_permohonan){
        $this->permohonan = Permohonan::findOrFail($id_permohonan);
        $this->nominal_anggaran = $this->permohonan->nominal_anggaran;
                
        $this->kegiatans = PerbaikanRab::with(['rincian.satuan'])->where('id_permohonan', $this->permohonan->id)->latest()->get();
        if(!$this->kegiatans->count() > 0){
            $kegiatans = RabPermohonan::with(['rincian.satuan'])->where('id_permohonan', $this->permohonan->id)->get();
        }
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
                    'total_kegiatan' => 0
                ];
                foreach($item->rincian as $k2 => $child){
                    $this->kegiatan_rab[$k1]['rincian'][$k2] = [
                        'id_rincian' => $child->id,
                        'kegiatan' => $child->keterangan,
                        'volume' => $child->volume,
                        'satuan' => $child->id_satuan,
                        'harga_satuan' => $child->harga,
                        'subtotal' => $child->subtotal,
                    ];
                }
            }
    }

    protected $step_rules = [
        1 => [],
        2 => [],
        3 => [
            'file_nphd' => 'required'
        ]
    ];
    
    public $listeners = ['pdf-ready','close-modal'];

    public function render()
    {
        return view('livewire.nphd.review');
    }

    public function nextStep(){
        if (!empty($this->rules[$this->step])) {
            $this->validate($this->rules[$this->step]);
        }

        $this->step++;
    }

    public function prevStep(){
        $this->step--;
    }

    public function generate_pdf() : void {
        $dir = 'draft_nphd';
        $filename = 'nphd_'.$this->permohonan->id.$this->permohonan->tahun_apbd.'.pdf';

        $pimpinan_lembaga = $this->permohonan->lembaga?->pengurus->where('jabatan', 'Pimpinan')->first();

        // if(!Storage::disk('public')->exists($dir.'/'.$filename)){
            $pdf = Pdf::loadView('pdf.nphd', ['data' => $this->permohonan, 'kegiatans' => $this->kegiatans, 'nominal_anggaran' => $this->nominal_anggaran, 'pimpinan_lembaga' => $pimpinan_lembaga])
                ->setPaper('A4', 'portrait');

            // Pastikan folder ada (di disk 'public' = storage/app/public)
            Storage::disk('public')->makeDirectory($dir);

            // (opsional, sanity check absolut path & permission)
            $absDir = Storage::disk('public')->path($dir);
            File::ensureDirectoryExists($absDir, 0775);
            if (!is_writable($absDir)) {
                throw new \RuntimeException("Direktori tidak writable: {$absDir}");
            }

            // Simpan PDF langsung ke disk 'public'
            Storage::disk('public')->put("{$dir}/{$filename}", $pdf->output());

        // }

        $url = asset("storage/{$dir}/{$filename}");

        $this->dispatch('pdf-ready', [
            'url' => $url
        ]);
    }
}
