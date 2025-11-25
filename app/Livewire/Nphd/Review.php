<?php

namespace App\Livewire\Nphd;

use App\Helpers\General;
use App\Models\PerbaikanRab;
use App\Models\Permohonan;
use App\Models\RabPermohonan;
use App\Models\Status_permohonan;
use App\Services\ActivityLogService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Review extends Component
{
    public $permohonan;

    public $step = 1;
    
    public $nominal_anggaran;
    public $total_kegiatan = 0;
    public $kegiatans;
    public $kegiatan_urusan = [];
    public $kegiatan_rab = [];

    public $saksi_skpd;
    public $saksi_lembaga;

    public $nomor_nphd_skpd;
    public $nomor_nphd_lembaga;
    public $tanggal_nphd;

    public $file_nphd;

    public function mount($id_permohonan){
        $this->permohonan = Permohonan::findOrFail($id_permohonan);
        $this->nominal_anggaran = $this->permohonan->nominal_anggaran;
                
        $this->kegiatans = PerbaikanRab::where('id_permohonan', $this->permohonan->id)->latest()->get();
        if(!$this->kegiatans->count() > 0){
            $this->kegiatans = RabPermohonan::where('id_permohonan', $this->permohonan->id)->get();
        }

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
                'total_kegiatan' => 0
            ];
        }

        $this->kegiatan_urusan = json_decode($this->permohonan->lembaga?->urusan?->kegiatan, true);

        $this->saksi_skpd = $this->permohonan->skpd?->detail?->nama_sekretaris && $this->permohonan->lembaga?->urusan?->kepala_urusan;
        $this->saksi_lembaga = $this->permohonan->lembaga?->pengurus[1]?->name && $this->permohonan->lembaga?->pengurus[2]?->name;
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
        $waktu_sekarang = General::getIndoTerbilangDate($this->tanggal_nphd);
        $waktu_sekarang['tanggal_penuh'] = $this->tanggal_nphd;

        $pimpinan_lembaga = $this->permohonan->lembaga?->pengurus->where('jabatan', 'Pimpinan')->first();

        // if(!Storage::disk('public')->exists($dir.'/'.$filename)){
            $pdf = Pdf::loadView('pdf.nphd', [
                'data' => $this->permohonan, 
                'kegiatans' => $this->kegiatans, 
                'nominal_anggaran' => $this->nominal_anggaran, 
                'pimpinan_lembaga' => $pimpinan_lembaga, 
                'waktu' => $waktu_sekarang, 
                'nomor_skpd' => $this->nomor_nphd_skpd, 
                'nomor_lembaga' => $this->nomor_nphd_lembaga,
                'kegiatan_urusan' => $this->kegiatan_urusan
                ])->setPaper([0, 0, 210, 330], 'portrait');

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

    public function saveNphd(){
        $status = Status_permohonan::where('name', 'NPHD Sesuai')->first();
        DB::beginTransaction();

        try {
            $this->permohonan->update([
                'id_status' => $status->id,
            ]);

            ActivityLogService::log('nphd.permintaan-review', 'info', 'menyetujui permintaan nphd permohonan perihal '.$this->permohonan->perihal_mohon);
            
            DB::commit();

            return redirect()->route('nphd')->with('success', 'NPHD sudah sesuai dan siap dicairkan!');
        } catch (\Throwable $th) {
            DB::rollBack();

            return session()->flash('error', 'Review NPHD belum tersimpan, karena: '.$th->getMessage());
        }
    }
}
