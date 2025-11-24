<?php

namespace App\Livewire\Pencairan;

use App\Models\Pencairan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Validate;

class VerifikasiPencairan extends Component
{
    public $pencairan;
    public $keputusan;
    
    #[Validate('required|string')]
    public $catatan;

    public function layout()
    {
        return 'components.layouts.app';
    }

    public function mount($id_pencairan)
    {
        $this->pencairan = Pencairan::with(['permohonan.lembaga', 'permohonan.skpd'])
            ->findOrFail($id_pencairan);
    }

    public function verify()
    {
        $this->validate([
            'keputusan' => 'required|in:diverifikasi,ditolak',
            'catatan' => 'required|string|min:10',
        ]);

        try {
            $this->pencairan->update([
                'status' => $this->keputusan,
                'verified_by' => Auth::id(),
                'verified_at' => now(),
                'catatan_verifikasi' => $this->catatan,
            ]);

            session()->flash('success', 
                $this->keputusan === 'diverifikasi' 
                    ? 'Pencairan berhasil diverifikasi dan akan dilanjutkan ke approval!' 
                    : 'Pencairan ditolak!'
            );
            
            return redirect()->route('pencairan');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.pencairan.verifikasi-pencairan');
    }
}
