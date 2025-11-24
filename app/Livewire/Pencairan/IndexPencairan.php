<?php

namespace App\Livewire\Pencairan;

use App\Models\Pencairan;
use App\Models\Permohonan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class IndexPencairan extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $tahapFilter = '';
    public $tahunFilter = '';

    protected $queryString = ['search', 'statusFilter', 'tahapFilter', 'tahunFilter'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingTahapFilter()
    {
        $this->resetPage();
    }

    public function layout()
    {
        return 'components.layouts.app';
    }

    public function render()
    {
        $user = Auth::user();
        
        $query = Pencairan::with(['permohonan.lembaga', 'permohonan.skpd', 'verifier', 'approver']);

        // Role-based filtering
        if ($user->hasRole('Admin Lembaga')) {
            $query->whereHas('permohonan', function($q) use ($user) {
                $q->where('id_lembaga', $user->id_lembaga);
            });
        } elseif ($user->hasRole('Admin SKPD') || $user->hasRole('Reviewer')) {
            $query->whereHas('permohonan', function($q) use ($user) {
                $q->where('id_skpd', $user->id_skpd);
            });
        }

        // Search filter
        if ($this->search) {
            $query->whereHas('permohonan', function($q) {
                $q->where('perihal_mohon', 'like', '%' . $this->search . '%')
                  ->orWhereHas('lembaga', function($q2) {
                      $q2->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Status filter
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        // Tahap filter
        if ($this->tahapFilter) {
            $query->where('tahap_pencairan', $this->tahapFilter);
        }

        // Tahun filter
        if ($this->tahunFilter) {
            $query->whereHas('permohonan', function($q) {
                $q->where('tahun_apbd', $this->tahunFilter);
            });
        }

        $pencairans = $query->latest()->paginate(10);

        // Get available years for filter
        $tahunList = Permohonan::distinct()->pluck('tahun_apbd')->sort()->values();

        return view('livewire.pencairan.index-pencairan', [
            'pencairans' => $pencairans,
            'tahunList' => $tahunList,
        ]);
    }
}
