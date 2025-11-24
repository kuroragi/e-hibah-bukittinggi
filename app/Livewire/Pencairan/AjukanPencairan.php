<?php

namespace App\Livewire\Pencairan;

use App\Models\Pencairan;
use App\Models\Permohonan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

class AjukanPencairan extends Component
{
    use WithFileUploads;

    public $permohonan;
    public $tahap_pencairan = 1;

    public function layout()
    {
        return 'components.layouts.app';
    }
    
    #[Validate('required|date')]
    public $tanggal_pencairan;
    
    #[Validate('required|numeric|min:1000')]
    public $jumlah_pencairan;
    
    #[Validate('nullable')]
    public $keterangan;
    
    #[Validate('required|file|mimes:pdf|max:5120')]
    public $file_lpj;
    
    #[Validate('required|file|mimes:pdf,jpg,jpeg,png|max:5120')]
    public $file_realisasi;
    
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png,zip|max:10240')]
    public $file_dokumentasi;
    
    #[Validate('required|file|mimes:pdf,jpg,jpeg,png|max:5120')]
    public $file_kwitansi;
    
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:5120')]
    public $bukti;

    public function mount($id_permohonan)
    {
        $this->permohonan = Permohonan::with(['lembaga', 'skpd', 'nphd'])
            ->findOrFail($id_permohonan);
        
        // Auto set jumlah from NPHD if exists
        if ($this->permohonan->nphd) {
            $this->jumlah_pencairan = $this->permohonan->nphd->nilai_disetujui;
        }
        
        // Set tanggal default to today
        $this->tanggal_pencairan = now()->format('Y-m-d');
        
        // Check existing pencairan to determine tahap
        $lastPencairan = Pencairan::where('id_permohonan', $id_permohonan)
            ->orderBy('tahap_pencairan', 'desc')
            ->first();
        
        if ($lastPencairan) {
            $this->tahap_pencairan = $lastPencairan->tahap_pencairan + 1;
        }
    }

    public function submit()
    {
        $this->validate();

        try {
            // Store files
            $lpjPath = $this->file_lpj->store('pencairan/lpj', 'public');
            $realisasiPath = $this->file_realisasi->store('pencairan/realisasi', 'public');
            $kwitansiPath = $this->file_kwitansi->store('pencairan/kwitansi', 'public');
            
            $dokumentasiPath = $this->file_dokumentasi 
                ? $this->file_dokumentasi->store('pencairan/dokumentasi', 'public') 
                : null;
            
            $buktiPath = $this->bukti 
                ? $this->bukti->store('pencairan/bukti', 'public') 
                : null;

            // Create pencairan
            Pencairan::create([
                'id_permohonan' => $this->permohonan->id,
                'tanggal_pencairan' => $this->tanggal_pencairan,
                'jumlah_pencairan' => $this->jumlah_pencairan,
                'tahap_pencairan' => $this->tahap_pencairan,
                'status' => 'diajukan',
                'keterangan' => $this->keterangan,
                'file_lpj' => $lpjPath,
                'file_realisasi' => $realisasiPath,
                'file_dokumentasi' => $dokumentasiPath,
                'file_kwitansi' => $kwitansiPath,
                'bukti' => $buktiPath,
            ]);

            session()->flash('success', 'Pengajuan pencairan berhasil diajukan!');
            return redirect()->route('pencairan');
            
        } catch (\Exception $e) {
            // Cleanup uploaded files on error
            if (isset($lpjPath)) Storage::disk('public')->delete($lpjPath);
            if (isset($realisasiPath)) Storage::disk('public')->delete($realisasiPath);
            if (isset($kwitansiPath)) Storage::disk('public')->delete($kwitansiPath);
            if (isset($dokumentasiPath)) Storage::disk('public')->delete($dokumentasiPath);
            if (isset($buktiPath)) Storage::disk('public')->delete($buktiPath);
            
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.pencairan.ajukan-pencairan');
    }
}
