<?php

namespace App\Livewire\Permohonan;

use App\Models\BeritaAcara;
use App\Models\KelengkapanBeritaAcara;
use App\Models\KelengkapanPerbaikan;
use App\Models\PerbaikanRab;
use App\Models\Permohonan;
use App\Models\PertanyaanKelengkapan;
use App\Models\PertanyaanPerbaikan;
use App\Models\Skpd;
use App\Models\Status_permohonan;
use App\Models\UrusanSkpd;
use App\Models\VerifikasiPermohonan;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class ReviewPerbaikan extends Component
{
    
    use WithFileUploads;

    public $is_lembaga_verif = false;
    public $is_proposal_verif = false;
    public $is_pendukung_verif = false;

    public $permohonan;
    public $skpds;
    public $id_skpd;
    public $urusans;
    public $urusan;
    public $kegiatans;
    public $questions;
    public $answer = [];
    public $veriffied = false;

    private $id_perbaikan;
    public $perbaikan_questions;
    public $kelengkapan_perbaikan = [];
    public $list_kelengkapan_perbaikan = [];
    public $is_lengkap_perbaikan = false;

    public $is_lengkap;
    #[Validate('required')]
    public $file_kelengkapan_adm;
    #[Validate('required')]
    public $no_kelengkapan_adm;
    #[Validate('required')]
    public $tanggal_kelengkapan_adm;
    #[Validate('required')]
    public $file_tinjau_lap;
    #[Validate('required')]
    public $no_tinjau_lap;
    #[Validate('required')]
    public $tanggal_tinjau_lap;

    public $berita_acara;

    public $status_rekomendasi;
    public $nominal_rekomendasi;
    public $tanggal_rekomendasi;
    public $catatan_rekomendasi;
    public $file_pemberitahuan;
    public $file_pemberitahuan_perbaikan;

    public $listeners = ['updatethis->status_rekomendasiment' => 'veriffiedStatement'];

    public function mount($id_permohonan = null){
        $this->permohonan = Permohonan::with(['lembaga', 'skpd', 'status', 'pendukung', 'perbaikanProposal.perbaikan_rab'])->where('id', $id_permohonan)->first();
        $this->skpds = Skpd::all();
        $this->id_skpd = $this->permohonan->id_skpd;
        $this->urusans = UrusanSkpd::where('id_skpd', $this->id_skpd)->get();
        $this->urusan = $this->permohonan->urusan;
        $this->kegiatans = PerbaikanRab::where('id_permohonan', $id_permohonan)->get();

        $verifikasi = VerifikasiPermohonan::where('id_permohonan', $this->permohonan->id)->first();
        if($verifikasi){
            $this->is_lembaga_verif = $verifikasi->is_lembaga_verif;
            $this->is_proposal_verif = $verifikasi->is_proposal_verif;
            $this->is_pendukung_verif = $verifikasi->is_pendukung_verif;
        }

        $this->questions = PertanyaanKelengkapan::with(['children' => function($query) {$query->orderBy('order');}])->where('id_parent', null)->orderBy('order')->get();
        foreach($this->questions as $item){
            foreach($item->children as $child){
                $this->answer[$child->id] = [
                    'is_ada' => false,
                    'is_sesuia' => false,
                    'keterangan' => ''
                ];
            }
        }
        $this->berita_acara = BeritaAcara::firstWhere('id_permohonan', $this->permohonan->id);
        if($this->berita_acara){
            $kelengkapan = KelengkapanBeritaAcara::where('id_berita_acara', $this->berita_acara->id)->get();
            foreach($this->questions as $question){
                foreach($question->children as $child){
                    $existing = $kelengkapan->firstWhere('id_pertanyaan', $child->id);

                    $this->answer[$child->id] = [
                        'is_ada' => $existing?->is_ada ?? false,
                        'is_sesuai' => $existing?->is_sesuai ?? false,
                        'keterangan' => $existing?->keterangan ?? '',
                    ];
                }
            }

            $this->is_lengkap = $this->berita_acara->is_lengkap;
            if($this->is_lengkap == 1){
                $this->veriffied = true;
            }
            $this->file_kelengkapan_adm = $this->berita_acara->file_kelengkapan_adm;
            $this->no_kelengkapan_adm = $this->berita_acara->no_kelengkapan_adm;
            $this->tanggal_kelengkapan_adm = $this->berita_acara->tanggal_kelengkapan_adm;
            $this->file_tinjau_lap = $this->berita_acara->file_tinjau_lap;
            $this->no_tinjau_lap = $this->berita_acara->no_tinjau_lap;
            $this->tanggal_tinjau_lap = $this->berita_acara->tanggal_tinjau_lap;
        }

        $this->perbaikan_questions = PertanyaanPerbaikan::all();
        $this->id_perbaikan = $this->permohonan->perbaikanProposal()->latest()->first()->id;
        $jawaban = KelengkapanPerbaikan::where('id_perbaikan', $this->id_perbaikan)->get()->keyBy('id_pertanyaan_perbaikan');

        $this->list_kelengkapan_perbaikan = $this->perbaikan_questions->map(function ($item) use ($jawaban) {
            $jawab = $jawaban->get($item->id);

            return [
                'id_perbaikan' => $this->id_perbaikan,
                'id_pertanyaan' => $item->id,
                'question' => $item->question,
                'is_ada' => (bool) ($jawab->is_ada ?? false),
                'is_sesuai' => (bool) ($jawab->is_sesuai ?? false),
                'keterangan' => $jawab->keterangan ?? '',
            ];
        })->toArray();

    }

    protected function rules(){
        $rules = [];
        foreach($this->questions as $question){
            foreach ($question->children as $key => $child) {
                $id = $child->id;

                if (empty($this->answer[$id]['is_ada']) || empty($this->answer[$id]['is_sesuai'])) {
                    $rules["answer.$id.keterangan"] = 'required|string';
                }
            }
        }

        return $rules;
    }

    public function render()
    {
        return view('livewire.permohonan.review-perbaikan');
    }

    

    public function veriffiedStatement(){
        VerifikasiPermohonan::updateOrCreate(
            ['id_permohonan' => $this->permohonan->id],
            [
                'is_lembaga_verif' => $this->is_lembaga_verif,
                'is_proposal_verif' => $this->is_proposal_verif,
                'is_pendukung_verif' => $this->is_pendukung_verif,
            ]
        );
    }

    public function hasVeriffied(){
        $this->veriffied = true;
    }

    public function store_berita_acara($VerificationBool){
        if($VerificationBool == 0) return;
        $this->validate();
        DB::beginTransaction();
        try {
            $ext_kelengkapan_adm = $this->file_kelengkapan_adm->getclientOriginalExtension();
            $kelengkapan_adm_path = $this->file_kelengkapan_adm->storeAs('berita_acara', 'kelengkapan_adm_'.Auth::user()->id.$this->permohonan->id.date('now').'.'.$ext_kelengkapan_adm, 'public');
            
            $ext_tinjau_lap = $this->file_tinjau_lap->getclientOriginalExtension();
            $tinjau_lap_path = $this->file_tinjau_lap->storeAs('berita_acara', 'tinjau_lap_'.Auth::user()->id.$this->permohonan->id.date('now').'.'.$ext_tinjau_lap, 'public');
            
            $berita_acara = BeritaAcara::create([
                'id_permohonan' => $this->permohonan->id,
                'is_lengkap' => $this->is_lengkap,
                'file_kelengkapan_adm' => $kelengkapan_adm_path,
                'no_kelengkapan_adm' => $this->no_kelengkapan_adm,
                'tanggal_kelengkapan_adm' => $this->tanggal_kelengkapan_adm,
                'file_tinjau_lap' => $tinjau_lap_path,
                'no_tinjau_lap' => $this->no_tinjau_lap,
                'tanggal_tinjau_lap' => $this->tanggal_tinjau_lap,
            ]);
            
            foreach($this->questions as $question){
                    foreach($question->children as $child){
                    
                    KelengkapanBeritaAcara::create([
                        'id_berita_acara' => $berita_acara->id,
                        'id_pertanyaan' => $child->id,
                        'is_ada' => $this->answer[$child->id]['is_ada'] ?? false,
                        'is_sesuai' => $this->answer[$child->id]['is_sesuai'] ?? false,
                        'is_keterangan' => $this->answer[$child->id]['is_keterangan'] ?? '',
                    ]);

                }
            }

            ActivityLogService::log('permohonan.review-perbaikan-permohonan', 'info', 'review permohonan yang telah diperbaiki', json_encode($berita_acara));
            
            DB::commit();
            
            Permohonan::where('id', $this->permohonan->id)->increment('id_status');

            return redirect()->route('permohonan');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            session()->flash('error', 'Gagal menyimpan data: ' . $th->getMessage());
        }
        
    }

    public function store_pemberitahuan_perbaikan(){
        DB::beginTransaction();

        $ext_file_pemberitahuan_perbaikan = $this->file_pemberitahuan_perbaikan->getclientOriginalExtension();
        $file_pemberitahuan_perbaikan_path = $this->file_pemberitahuan_perbaikan->storeAs('berita_acara', 'file_pemberitahuan_perbaikan_'.Auth::user()->id.$this->permohonan->id.date('now').'.'.$ext_file_pemberitahuan_perbaikan, 'public');
        
        try {

            if($this->status_rekomendasi == 1){
                $status = Status_permohonan::where('name', 'direkomendasi')->first()->id;

                // $perbaikan = $this->permohonan->perbaikanProposal->last()?->perbaikanRab->orderByDesc('id')?->first();
                // dd($perbaikan);

                $permohonan = $this->permohonan->update([
                    'id_status' => $status,
                    'file_pemberitahuan_perbaikan' => $file_pemberitahuan_perbaikan_path
                ]);

                $status = [
                    'event' => 'permohonan.approved',
                    'type' => 'warning',
                    'message' => 'Permohonan diterima dan direkomendasikan'
                ];
                
            }else if($this->status_rekomendasi == 2){
                $status = Status_permohonan::where('name', 'koreksi')->first()->id;
                
                $permohonan = $this->permohonan->update([
                    'id_status' => $status,
                    'status_rekomendasi' => $this->status_rekomendasi,
                    'nominal_rekomendasi' => $this->nominal_rekomendasi,
                    'tanggal_rekomendasi' => $this->tanggal_rekomendasi,
                    'catatan_rekomendasi' => $this->catatan_rekomendasi,
                    'file_pemberitahuan_perbaikan' => $file_pemberitahuan_perbaikan_path
                ]);

                $status = [
                    'event' => 'permohonan.need-correction',
                    'type' => 'warning',
                    'message' => 'Permohonan diterima namun butuh perbaikan'
                ];
            }else if($this->status_rekomendasi == 3){
                $status = Status_permohonan::where('name', 'ditolak')->first()->id;
                
                $permohonan = $this->permohonan->update([
                    'id_status' => $status,
                    'catatan_rekomendasi' => $this->catatan_rekomendasi,
                ]);

                $status = [
                    'event' => 'permohonan.denied',
                    'type' => 'warning',
                    'message' => 'Permohonan ditolak'
                ];
            }

            ActivityLogService::log($status['event'], $status['type'], $status['message'], json_encode($permohonan->toArray()));
            
            
            DB::commit();

            return redirect()->route('permohonan');
        } catch (\Throwable $th) {
            DB::rollBack();
            
            if(Storage::disk('public')->exists($file_pemberitahuan_perbaikan_path)){
                Storage::disk('public')->delete($file_pemberitahuan_perbaikan_path);
            }
            
            dd($th);
            session()->flash('error', 'Gagal menyimpan data: ' . $th->getMessage());
        }
    }

    public function recomending() {
        $this->status_rekomendasi = 1;
    }

    public function correcting() {
        $this->status_rekomendasi = 2;
    }

    public function deniying() {
        $this->status_rekomendasi = 3;
    }

    public function storeReviewPerbaikan(){
        DB::beginTransaction();

        try {
            foreach ($this->list_kelengkapan_perbaikan as $key => $item) {
                KelengkapanPerbaikan::create([
                    'id_perbaikan' => $this->list_kelengkapan_perbaikan[$key]['id_perbaikan'],
                    'id_pertanyaan_perbaikan' => $this->list_kelengkapan_perbaikan[$key]['id_pertanyaan'],
                    'is_ada' => $this->list_kelengkapan_perbaikan[$key]['is_ada'],
                    'is_sesuai' => $this->list_kelengkapan_perbaikan[$key]['is_sesuai']
                ]);
            };

            ActivityLogService::log('permohonan.review-perbaikan-permohonan', 'info', 'review permohonan yang telah diperbaiki', json_encode($this->list_kelengkapan_perbaikan));

            DB::commit();

            session()->flash('success', 'berhasil menyimpan data kelengkapan perbaikan');
            $this->permohonan->update([
                'id_status' => 12
            ]);

            return redirect()->route('permohonan');
        } catch (\Throwable $th) {
            session()->flash('error', 'gagal menyimpan data kelengkapan perbaikan: '.$th->getMessage());
            dd($th);
            DB::rollBack();
        }
    }
}
