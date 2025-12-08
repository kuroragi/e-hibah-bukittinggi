<?php

namespace App\Http\Controllers;

use App\Models\Lembaga;
use App\Models\Pencairan;
use App\Models\Permohonan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function dasboard(){
        $user = User::all();
        $yearNow = date('2026'); // contoh: 2025
        $yearStart = $yearNow - 4; // 2021
        if(Auth::user()->hasRole('Super Admin')){
            $permohonan = Permohonan::all();
            $dataPerTahun = Permohonan::selectRaw('tahun_apbd, ROUND(SUM(nominal_anggaran) / 1000000, 1) as total')
                ->whereBetween('tahun_apbd', [$yearStart, $yearNow])
                ->groupBy('tahun_apbd')
                ->orderBy('tahun_apbd')
                ->pluck('total', 'tahun_apbd');
        }else if(Auth::user()->hasRole('Admin Lembaga')){
            $permohonan = Permohonan::where('id_lembaga', Auth::user()->id_lembaga)->get();
            $dataPerTahun = Permohonan::selectRaw('tahun_apbd, ROUND(SUM(nominal_anggaran) / 1000000, 1) as total')
                ->whereBetween('tahun_apbd', [$yearStart, $yearNow])
                ->where('id_lembaga', Auth::user()->id_lembaga)
                ->groupBy('tahun_apbd')
                ->orderBy('tahun_apbd')
                ->pluck('total', 'tahun_apbd');
        }else{
            $permohonan = Permohonan::where('id_skpd', Auth::user()->id_skpd)->get();
            $dataPerTahun = Permohonan::selectRaw('tahun_apbd, ROUND(SUM(nominal_anggaran) / 1000000, 1) as total')
                ->whereBetween('tahun_apbd', [$yearStart, $yearNow])
                ->where('id_skpd', Auth::user()->id_skpd)
                ->groupBy('tahun_apbd')
                ->orderBy('tahun_apbd')
                ->pluck('total', 'tahun_apbd');
        }
        $lembaga = Lembaga::all();
            
        $years = collect(range($yearStart, $yearNow));
        $pencairan = $years->mapWithKeys(fn($year) => [$year => $dataPerTahun->get($year, 0)]);

        // Statistik Pencairan Dana Hibah
        $pencairanStats = $this->getPencairanStats();
        
        // Widget tambahan
        $recentActivity = $this->getRecentActivity();
        $topLembaga = $this->getTopLembaga();
        $budgetProgress = $this->getBudgetProgress();

        return view('pages.dashboard', [
            'permohonan' => $permohonan,
            'user' => $user,
            'lembaga' => $lembaga,
            'pencairan' => $pencairan,
            'pencairanStats' => $pencairanStats,
            'recentActivity' => $recentActivity,
            'topLembaga' => $topLembaga,
            'budgetProgress' => $budgetProgress,
        ]);
    }

    private function getPencairanStats()
    {
        $user = Auth::user();
        
        $query = Pencairan::query();
        
        // Filter berdasarkan role
        if ($user->hasRole('Admin Lembaga')) {
            $query->whereHas('permohonan', function($q) use ($user) {
                $q->where('id_lembaga', $user->id_lembaga);
            });
        } elseif ($user->hasRole('Reviewer') || $user->hasRole('Admin SKPD')) {
            $query->whereHas('permohonan', function($q) use ($user) {
                $q->where('id_skpd', $user->id_skpd);
            });
        }
        
        $totalPencairan = $query->count();
        $totalDana = $query->where('status', 'dicairkan')->sum('jumlah_pencairan');
        $diajukan = $query->where('status', 'diajukan')->count();
        $diverifikasi = $query->where('status', 'diverifikasi')->count();
        $disetujui = $query->where('status', 'disetujui')->count();
        $ditolak = $query->where('status', 'ditolak')->count();
        $dicairkan = $query->where('status', 'dicairkan')->count();
        
        return [
            'total' => $totalPencairan,
            'totalDana' => $totalDana,
            'diajukan' => $diajukan,
            'diverifikasi' => $diverifikasi,
            'disetujui' => $disetujui,
            'ditolak' => $ditolak,
            'dicairkan' => $dicairkan,
            'pending' => $diajukan + $diverifikasi + $disetujui, // yang masih proses
        ];
    }

    private function getRecentActivity()
    {
        $user = Auth::user();
        
        // Aktivitas terbaru pencairan
        $query = Pencairan::with(['permohonan.lembaga', 'verifier', 'approver'])
                          ->orderBy('updated_at', 'desc')
                          ->limit(5);
        
        // Filter berdasarkan role
        if ($user->hasRole('Admin Lembaga')) {
            $query->whereHas('permohonan', function($q) use ($user) {
                $q->where('id_lembaga', $user->id_lembaga);
            });
        } elseif ($user->hasRole('Reviewer') || $user->hasRole('Admin SKPD')) {
            $query->whereHas('permohonan', function($q) use ($user) {
                $q->where('id_skpd', $user->id_skpd);
            });
        }
        
        return $query->get()->map(function($pencairan) {
            $action = 'Diajukan';
            $icon = 'bi-arrow-up-circle';
            $color = 'warning';
            
            switch($pencairan->status) {
                case 'diverifikasi':
                    $action = 'Diverifikasi oleh ' . ($pencairan->verifier->name ?? 'Reviewer');
                    $icon = 'bi-search';
                    $color = 'info';
                    break;
                case 'disetujui':
                    $action = 'Disetujui oleh ' . ($pencairan->approver->name ?? 'Admin SKPD');
                    $icon = 'bi-check-lg';
                    $color = 'primary';
                    break;
                case 'ditolak':
                    $action = 'Ditolak';
                    $icon = 'bi-x-lg';
                    $color = 'danger';
                    break;
                case 'dicairkan':
                    $action = 'Dana Dicairkan';
                    $icon = 'bi-check-all';
                    $color = 'success';
                    break;
            }
            
            return [
                'lembaga' => $pencairan->permohonan->lembaga->name ?? 'N/A',
                'action' => $action,
                'amount' => $pencairan->jumlah_pencairan,
                'time' => $pencairan->updated_at,
                'icon' => $icon,
                'color' => $color
            ];
        });
    }

    private function getTopLembaga()
    {
        $user = Auth::user();
        
        $query = Permohonan::with('lembaga')
                          ->selectRaw('id_lembaga, COUNT(*) as total_permohonan, SUM(nominal_anggaran) as total_anggaran')
                          ->groupBy('id_lembaga')
                          ->orderBy('total_anggaran', 'desc')
                          ->limit(5);
        
        // Filter berdasarkan role
        if ($user->hasRole('Admin Lembaga')) {
            $query->where('id_lembaga', $user->id_lembaga);
        } elseif ($user->hasRole('Reviewer') || $user->hasRole('Admin SKPD')) {
            $query->where('id_skpd', $user->id_skpd);
        }
        
        return $query->get()->map(function($item) {
            return [
                'name' => $item->lembaga->name ?? 'N/A',
                'total_permohonan' => $item->total_permohonan,
                'total_anggaran' => $item->total_anggaran,
            ];
        });
    }

    private function getBudgetProgress()
    {
        $user = Auth::user();
        $currentYear = date('Y');
        
        $query = Permohonan::where('tahun_apbd', $currentYear);
        
        // Filter berdasarkan role
        if ($user->hasRole('Admin Lembaga')) {
            $query->where('id_lembaga', $user->id_lembaga);
        } elseif ($user->hasRole('Reviewer') || $user->hasRole('Admin SKPD')) {
            $query->where('id_skpd', $user->id_skpd);
        }
        
        $totalAnggaran = $query->sum('nominal_anggaran');
        $totalRealisasi = Pencairan::whereHas('permohonan', function($q) use ($user, $currentYear) {
                                      $q->where('tahun_apbd', $currentYear);
                                      if ($user->hasRole('Admin Lembaga')) {
                                          $q->where('id_lembaga', $user->id_lembaga);
                                      } elseif ($user->hasRole('Reviewer') || $user->hasRole('Admin SKPD')) {
                                          $q->where('id_skpd', $user->id_skpd);
                                      }
                                  })
                                  ->where('status', 'dicairkan')
                                  ->sum('jumlah_pencairan');
        
        $percentage = $totalAnggaran > 0 ? ($totalRealisasi / $totalAnggaran) * 100 : 0;
        
        return [
            'total_anggaran' => $totalAnggaran,
            'total_realisasi' => $totalRealisasi,
            'sisa_anggaran' => $totalAnggaran - $totalRealisasi,
            'percentage' => round($percentage, 1),
            'year' => $currentYear
        ];
    }

    public function permission(){
        return view('pages.permission');
    }

    public function role(){
        return view('pages.role');
    }
}
