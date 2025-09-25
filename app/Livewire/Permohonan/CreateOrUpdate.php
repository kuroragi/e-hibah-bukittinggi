<?php

namespace App\Livewire\Permohonan;

use App\Models\Permohonan;
use App\Models\Skpd;
use App\Models\UrusanSkpd;
use App\Models\User;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateOrUpdate extends Component
{
    use WithFileUploads;

    public $id_permohonan;
    public $id_lembaga;
    public $skpds = [];
    public $all_urusans = [];
    public $urusans = [];

    #[Validate('required')]
    public $usulan_apbd;

    // Surat Permohonan
    #[Validate('required')]
    public $no_mohon;
    #[Validate('required')]
    public $tanggal_mohon;
    #[Validate('required')]
    public $perihal_mohon;
    #[Validate('required')]
    public $file_mohon;

    // Proposal
    #[Validate('required')]
    public $no_proposal;
    #[Validate('required')]
    public $tanggal_proposal;
    #[Validate('required')]
    public $title;
    public $id_skpd;
    public $urusan;
    #[Validate('required')]
    public $awal_laksana;
    #[Validate('required')]
    public $akhir_laksana;
    #[Validate('required')]
    public $file_proposal;

    // Isi Proposal
    #[Validate('required')]
    public $latar_belakang;
    #[Validate('required')]
    public $maksud_tujuan;
    #[Validate('required')]
    public $keterangan;

    public $nominal_rab = 0;
    public $id_status = 1;
    public $nominal_rekomendasi = 0;
    public $tanggal_rekomendasi;
    public $catatan_rekomendasi;
    public $file_pemberitahuan;

    protected $listeners = ['id_skpd_updated'];
    
    public function mount($id = null){
        $user = User::with(['lembaga'])->find(Auth::user()->id);
        $this->id_lembaga = $user->lembaga->id;
        $this->skpds = Skpd::all();
        $this->urusans = UrusanSkpd::all();

        if($id){
            $permohonan = Permohonan::find($id);
            if($permohonan){
                $this->usulan_apbd = $permohonan->usulan_apbd;
                $this->no_mohon = $permohonan->no_mohon;
                $this->tanggal_mohon = $permohonan->tanggal_mohon;
                $this->perihal_mohon = $permohonan->perihal_mohon;
                $this->file_mohon = $permohonan->file_mohon;
                $this->no_proposal = $permohonan->no_proposal;
                $this->tanggal_proposal = $permohonan->tanggal_proposal;
                $this->title = $permohonan->title;
                $this->urusan = $permohonan->urusan;
                $this->id_skpd = $permohonan->id_skpd;
                $this->awal_laksana = $permohonan->awal_laksana;
                $this->akhir_laksana = $permohonan->akhir_laksana;
                $this->file_proposal = $permohonan->file_proposal;
                $this->latar_belakang = $permohonan->latar_belakang;
                $this->maksud_tujuan = $permohonan->maksud_tujuan;
                $this->keterangan = $permohonan->keterangan;
                $this->nominal_rab = $permohonan->nominal_rab;
                $this->id_status = $permohonan->id_status;
                $this->nominal_rekomendasi = $permohonan->nominal_rekomendasi;
                $this->tanggal_rekomendasi = $permohonan->tanggal_rekomendasi;
                $this->catatan_rekomendasi = $permohonan->catatan_rekomendasi;
                $this->file_pemberitahuan = $permohonan->file_pemberitahuan;
            }
        }

            $this->id_skpd = Auth::user()->id_skpd;
            $this->urusan = Auth::user()->id_urusan;
    }
    
    public function render()
    {
        return view('livewire.permohonan.create-or-update');
    }

    public function updatedSkpd(){
        $this->urusans = collect($this->all_urusans)->where('id_skpd', $this->id_skpd)->values()->toArray();
    }

    #[On('updated_id_skpd')]
    public function updatedIdSkpd($data)
    {
        // Setiap kali id_skpd berubah, ambil urusan terkait dari DB
        $this->urusans = UrusanSkpd::where('id_skpd', $data)
            ->select('id', 'nama_urusan')
            ->orderBy('nama_urusan')
            ->get();

        // Reset pilihan urusan
        $this->urusan = '';
    }

    public function store(){
        $this->validate();
        $ext_mohon = $this->file_mohon->getclientOriginalExtension();
        $mohon_path = $this->file_mohon->storeAs('permohonan', 'surat_permohonan_'.Auth::user()->id.$this->id_lembaga.date('now').'.'.$ext_mohon, 'public');

        $ext_proposal = $this->file_proposal->getclientOriginalExtension();
        $proposal_path = $this->file_mohon->storeAs('permohonan', 'proposal_permohonan_'.Auth::user()->id.$this->id_lembaga.date('now').'.'.$ext_proposal, 'public');

        DB::beginTransaction();
        try {
            $permohonan = Permohonan::create([
                'id_lembaga' => $this->id_lembaga,
                'tahun_apbd' => $this->usulan_apbd,
                'no_mohon' => $this->no_mohon,
                'tanggal_mohon' => date('Y-m-d', strtotime($this->tanggal_mohon)),
                'perihal_mohon' => $this->perihal_mohon,
                'file_mohon' => $mohon_path,
                'no_proposal' => $this->no_proposal,
                'tanggal_proposal' => date('Y-m-d', strtotime($this->tanggal_proposal)),
                'title' => $this->title,
                'urusan' => $this->urusan,
                'id_skpd' => $this->id_skpd,
                'awal_laksana' => $this->awal_laksana,
                'akhir_laksana' => $this->akhir_laksana,
                'file_proposal' => $proposal_path,
                'latar_belakang' => $this->latar_belakang,
                'maksud_tujuan' => $this->maksud_tujuan,
                'keterangan' => $this->keterangan,
                'nominal_rab' => $this->nominal_rab,
                'id_status' => $this->id_status,
                'nominal_rekomendasi' => $this->nominal_rekomendasi,
                'tanggal_rekomendasi' => $this->tanggal_rekomendasi,
                'catatan_rekomendasi' => $this->catatan_rekomendasi,
                'file_pemberitahuan' => $this->file_pemberitahuan,
            ]);

            ActivityLogService::log('permohonan.create', 'success', 'penambahan permohonan baru '.$this->perihal_mohon);

            DB::commit();
            return redirect()->route('permohonan.isi_pendukung', ['id_permohonan' => $permohonan->id])->with('success', 'Berhasil menambahkan permohonan hibah, lanjutkan dengan Isi Data Pendukung');
        } catch (\Throwable $th) {
            DB::rollBack();

            if(Storage::disk('public')->exists($mohon_path)){
                Storage::disk('public')->delete($mohon_path);
            }

            if(Storage::disk('public')->exists($proposal_path)){
                Storage::disk('public')->delete($proposal_path);
            }

            session()->flash('error', 'Gagal menyimpan data: ' . $th->getMessage());
        }
        

    }
}
