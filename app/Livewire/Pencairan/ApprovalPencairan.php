<?php

namespace App\Livewire\Pencairan;

use App\Models\Pencairan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Validate;

class ApprovalPencairan extends Component
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
        $this->pencairan = Pencairan::with(['permohonan.lembaga.bank', 'permohonan.skpd', 'verifier'])
            ->findOrFail($id_pencairan);
    }

    public function approve()
    {
        $this->validate([
            'keputusan' => 'required|in:disetujui,ditolak',
            'catatan' => 'required|string|min:10',
        ]);

        try {
            $this->pencairan->update([
                'status' => $this->keputusan,
                'approved_by' => Auth::id(),
                'approved_at' => now(),
                'catatan_approval' => $this->catatan,
            ]);

            session()->flash('success', 
                $this->keputusan === 'disetujui' 
                    ? 'Pencairan berhasil disetujui dan akan diproses oleh Bendahara!' 
                    : 'Pencairan ditolak!'
            );
            
            return redirect()->route('pencairan');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.pencairan.approval-pencairan');
    }
}
