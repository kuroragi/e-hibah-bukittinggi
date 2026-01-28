<?php

namespace App\Livewire\Nphd;

use App\Models\Nphd;
use App\Models\PerbaikanRab;
use App\Models\Permohonan;
use App\Models\RabPermohonan;
use App\Models\Satuan;
use App\Models\Status_permohonan;
use App\Services\ActivityLogService;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class Show extends Component
{
    use WithFileUploads;

    public $permohonan;
    public $satuans;
    public $count_perbaikan = 1;

    public $nominal_anggaran;
    public $total_kegiatan = 0;
    public $kegiatans;
    public $kegiatan_rab = [];

    #[Validate('required|file|max:5120|mimes:pdf')]
    public $file_permintaan_nphd;
    
    public $listeners = ['pdf-ready','close-modal'];

    public function mount($id_permohonan){
        $this->permohonan = Permohonan::with(['lembaga', 'skpd', 'urusan_skpd', 'pendukung'])->where('id', $id_permohonan)->first();
        $this->nominal_anggaran = $this->permohonan->nominal_anggaran;
        $perbaikan_rab = PerbaikanRab::where('id_permohonan', $id_permohonan)->get();
        
        
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
        $this->satuans = Satuan::orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.nphd.show');
    }

    public function generate_pdf(){
        // $pdf = Pdf::loadView('pdf.nphd', ['data' => $this->permohonan])->setPaper('A4', 'portrait');
        $dir = 'draft_permintaan_nphd';
        $filename = 'permintaan_nphd_'.$this->permohonan->id.$this->permohonan->tahun_apbd;
        $ext = '.pdf';

        $pimpinan_lembaga = $this->permohonan->lembaga?->pengurus->where('jabatan', 'Pimpinan')->first();
        
        if($this->permohonan->file_permintaan_nphd && Storage::disk('public')->exists($dir.'/'.$filename.$ext)){
            Storage::disk('public')->delete($dir.'/'.$filename.$ext);
        }
        
        
        if(!Storage::disk('public')->exists($dir.'/'.$filename.$ext)){
            $pdf = Pdf::loadView('pdf.permohonan_nphd', ['data' => $this->permohonan, 'nominal_anggaran' => $this->nominal_anggaran, 'pimpinan_lembaga' => $pimpinan_lembaga])
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
            Storage::disk('public')->put("{$dir}/{$filename}.{$ext}", $pdf->output());

            $this->permohonan->update([
                'file_permintaan_nphd' => $dir.'/'.$filename.$ext
            ]);
        }

        $url = asset("storage/{$dir}/{$filename}.{$ext}");

        $this->dispatch('pdf-ready', [
            'url' => $url
        ]);

        ActivityLogService::log('nphd.generate-permintaan-nphd', 'warning', 'mengenerate permintaan nphd untuk permohonan perihal '.$this->permohonan->perihal_mohon);

        $this->permohonan->refresh();
    }

    public function store(){
        $this->validate();

        $dir = 'permintaan_nphd';
        $filename = 'permintaan_nphd_'.$this->permohonan->id.$this->permohonan->tahun_apbd;
        $ext = '.pdf';
        $path = $dir.'/'.$filename.$ext;

        DB::beginTransaction();

        if(Storage::disk('public')->exists($path)){
            Storage::disk('public')->delete($path);
        }
        
        $ext_permintaan_nphd = $this->file_permintaan_nphd->getclientOriginalExtension();
        $permintaan_nphd_path = $this->file_permintaan_nphd->storeAs($dir, $filename.'.'.$ext_permintaan_nphd, 'public');
        
        try {

            $status = Status_permohonan::where('name', 'Permohonan NPHD')->first();
            
            $add_permintaan_nphd = tap($this->permohonan)->update([
                'id_status' => $status->id,
                'file_permintaan_nphd' => $permintaan_nphd_path,
            ]);

            ActivityLogService::log('permohonan.upload-permohonan-nphd', 'info', 'upload file permintaan nphd untuk permohonan perihal '.$this->permohonan->perihal_mohon, json_encode(collect($add_permintaan_nphd->only([
                'id', 'perihal_mohon', 'title', 'file_permintaan_nphd'
            ]))->mapWithKeys(function ($value, $key) {
                return [
                    $key === 'title' ? 'judul_proposal' : $key => $value,
                ];
            })->toArray()));

            DB::commit();

            return redirect()->route('nphd')->with('success', 'Berhasil mengajukan permohonan NPHD');
        } catch (\Throwable $th) {
            DB::rollBack();
            
            if(Storage::disk('public')->exists($permintaan_nphd_path)){
                Storage::disk('public')->delete($permintaan_nphd_path);
            }
            
            session()->flash('danger', 'Gagal menyimpan permintaan nphd : '.$th->message);
        }
    }
}
