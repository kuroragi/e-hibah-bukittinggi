<?php

namespace App\Livewire\Permohonan;

use App\Livewire\Pages\Pertanyaan;
use App\Models\BeritaAcara;
use App\Models\KelengkapanBeritaAcara;
use App\Models\Permohonan;
use App\Models\PertanyaanKelengkapan;
use App\Models\RabPermohonan;
use App\Models\Skpd;
use App\Models\Status_permohonan;
use App\Models\UrusanSkpd;
use App\Models\VerifikasiPermohonan;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Review extends Component
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
    public $is_ada_all = [];
    public $is_sesuai_all = [];
    public $answer = [];
    public $veriffied = false;

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
    public $nominal_anggaran = 0;
    public $nominal_rekomendasi = 0;
    public $tanggal_rekomendasi;
    public $catatan_rekomendasi;
    public $file_pemberitahuan;

    public $listeners = ['is_lembaga_verified','is_proposal_verified','is_pendukung_verified'];

    public function mount($id_permohonan = null){
        $this->permohonan = Permohonan::with(['lembaga', 'skpd', 'status', 'pendukung'])->where('id', $id_permohonan)->first();
        $this->skpds = Skpd::all();
        $this->id_skpd = $this->permohonan->id_skpd;
        $this->urusans = UrusanSkpd::where('id_skpd', $this->id_skpd)->get();
        $this->urusan = $this->permohonan->urusan;
        $this->nominal_anggaran = $this->permohonan->nominal_rab;
        $this->nominal_rekomendasi = $this->permohonan->nominal_rab;
        $this->kegiatans = RabPermohonan::where('id_permohonan', $id_permohonan)->get();

        $verifikasi = VerifikasiPermohonan::where('id_permohonan', $this->permohonan->id)->first();
        if($verifikasi){
            $this->is_lembaga_verif = $verifikasi->is_lembaga_verif;
            $this->is_proposal_verif = $verifikasi->is_proposal_verif;
            $this->is_pendukung_verif = $verifikasi->is_pendukung_verif;
        }

        $this->questions = PertanyaanKelengkapan::with(['children' => function($query) {$query->orderBy('order');}])->where('id_parent', null)->orderBy('order')->get();
        foreach($this->questions as $item){
            foreach($item->children as $child){
                $this->answer[$item->id][$child->id] = [
                    'is_ada' => false,
                    'is_sesuai' => false,
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

                    $this->answer[$question->id][$child->id] = [
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
    }

    protected function rules(){
        $rules = [];
        foreach($this->questions as $question){
            foreach ($question->children as $key => $child) {
                $id = $child->id;

                if (empty($this->answer[$question->id][$id]['is_ada']) || empty($this->answer[$question->id][$id]['is_sesuai'])) {
                    $rules["answer.$id.keterangan"] = 'required|string';
                }
            }
        }

        return $rules;
    }

    public function render()
    {
        return view('livewire.permohonan.review');
    }

    public function veriffiedStatement(){
        $verification = VerifikasiPermohonan::updateOrCreate(
            ['id_permohonan' => $this->permohonan->id],
            [
                'is_lembaga_verif' => $this->is_lembaga_verif,
                'is_proposal_verif' => $this->is_proposal_verif,
                'is_pendukung_verif' => $this->is_pendukung_verif,
            ]
        );
        ActivityLogService::log('permohonan.veriffied-data', 'info', 'verifikasi pendukung permohonan', json_encode($verification->toArray()));
    }

    public function updatedIsLembagaVerif($value){
        $this->veriffiedStatement();
        if($value == true){
            $this->dispatch('is_lembaga_verified');
        }
    }

    public function updatedIsProposalVerif($value){
        $this->veriffiedStatement();
        if($value == true){
            $this->dispatch('is_proposal_verified');
        }
    }

    public function updatedIsPendukungVerif($value){
        $this->veriffiedStatement();
        if($value == true){
            $this->dispatch('is_pendukung_verified');
        }
    }

    public function checkAdaAll($id){
        $questions = PertanyaanKelengkapan::where('id_parent', $id)->get();
        foreach($questions as $item){
            $this->answer[$id][$item->id]['is_ada'] = true;
        }
    }

    public function checkSesuaiAll($id){
        $questions = PertanyaanKelengkapan::where('id_parent', $id)->get();
        foreach($questions as $item){
            $this->answer[$id][$item->id]['is_sesuai'] = true;
        }
    }

    public function hasVeriffied(){
        $this->veriffied = true;
    }

    public function updatedAnswer($value, $key){
        // [$id, $field] = explode('.', $key);
        // dd($id, $field);
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
                        'is_ada' => $this->answer[$question->id][$child->id]['is_ada'] ?? false,
                        'is_sesuai' => $this->answer[$question->id][$child->id]['is_sesuai'] ?? false,
                        'is_keterangan' => $this->answer[$question->id][$child->id]['is_keterangan'] ?? '',
                    ]);

                }
            }

            ActivityLogService::log('permohonan.review', 'warning', 'review permohonan', json_encode($berita_acara->toArray()));
            
            DB::commit();
            
            Permohonan::where('id', $this->permohonan->id)->increment('id_status');

            return redirect()->route('permohonan');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            session()->flash('error', 'Gagal menyimpan data: ' . $th->getMessage());
        }
        
    }

    public function store_pemberitahuan(){
        DB::beginTransaction();

        $ext_file_pemberitahuan = $this->file_pemberitahuan->getclientOriginalExtension();
        $file_pemberitahuan_path = $this->file_pemberitahuan->storeAs('berita_acara', 'file_pemberitahuan_'.Auth::user()->id.$this->permohonan->id.date('now').'.'.$ext_file_pemberitahuan, 'public');
        
        try {

            if($this->status_rekomendasi == 1){
                $status = Status_permohonan::where('name', 'direkomendasi')->first()->id;
                if(!$this->permohonan->nominal_anggaran == null){
                    $this->nominal_anggaran = $this->permohonan->nominal_rab;
                    $this->nominal_rekomendasi = $this->permohonan->nominal_rab;
                }
            }else if($this->status_rekomendasi == 2){
                $status = Status_permohonan::where('name', 'koreksi')->first()->id;
            }else if($this->status_rekomendasi == 1){
                $status = Status_permohonan::where('name', 'ditolak')->first()->id;
            }

            $permohonan = tap($this->permohonan)->update([
                'id_status' => $status,
                'status_rekomendasi' => $this->status_rekomendasi,
                'nominal_anggaran' => $this->nominal_anggaran,
                'nominal_rekomendasi' => $this->nominal_rekomendasi,
                'tanggal_rekomendasi' => $this->tanggal_rekomendasi,
                'catatan_rekomendasi' => $this->catatan_rekomendasi,
                'file_pemberitahuan' => $file_pemberitahuan_path
            ]);

            DB::commit();

            ActivityLogService::log('permohonan.review', 'info', 'kirim review permohonan', json_encode($permohonan->only([
                'id',
                'no_mohon',
                'perihal_mohon',
                'id_status',
                'status_rekomendasi',
                'nominal_anggaran',
                'nominal_rekomendasi',
                'tanggal_rekomendasi',
                'catatan_rekomendasi',
                'file_pemberitahuan',
            ])));

            return redirect()->route('permohonan');
        } catch (\Throwable $th) {
            DB::rollBack();
            
            if(Storage::disk('public')->exists($file_pemberitahuan_path)){
                Storage::disk('public')->delete($file_pemberitahuan_path);
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
}
