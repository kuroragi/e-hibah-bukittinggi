<?php

namespace App\Livewire\Lembaga;

use App\Models\KabKota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Lembaga;
use App\Models\Propinsi;
use App\Models\Skpd;
use App\Models\UrusanSkpd;
use App\Models\User;
use App\Services\ActivityLogService;
use App\Services\UserLogService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $skpd;
    public $all_urusan = [];
    public $urusan = [];
    public $propinsis = [];
    public $all_kabkotas = [];
    public $kabkotas = [];
    public $all_kecamatans = [];
    public $kecamatans = [];
    public $all_kelurahans = [];
    public $kelurahans = [];

    #[Validate('required')]
    public $name_lembaga;

    #[Validate('required')]
    public $acronym;

    #[Validate('required')]
    public $id_urusan;

    #[Validate('required')]
    public $id_skpd;

    #[Validate('required|email')]
    public $email;

    #[Validate('required')]
    public $phone;

    public $propinsi;
    public $kab_kota;
    public $kecamatan;
    #[Validate('required')]
    public $kelurahan;

    #[Validate('required')]
    public $alamat;

    #[Validate('required|image')]
    public $photo;

    #[Validate('required')]
    public $npwp;

    #[Validate('required')]
    public $no_akta_kumham;

    #[Validate('required')]
    public $date_akta_kumham;

    #[Validate('required|mimetypes:application/pdf')]
    public $file_akta_kumham;

    #[Validate('required')]
    public $no_domisili;

    #[Validate('required')]
    public $date_domisili;

    #[Validate('required|mimetypes:application/pdf')]
    public $file_domisili;

    #[Validate('required')]
    public $no_operasional;

    #[Validate('required')]
    public $date_operasional;

    #[Validate('required|mimetypes:application/pdf')]
    public $file_operasional;

    #[Validate('required')]
    public $no_pernyataan;

    #[Validate('required')]
    public $date_pernyataan;

    #[Validate('required|mimetypes:application/pdf')]
    public $file_pernyataan;

    public $nama_pimpinan; 
    #[Validate('required')]
    public $name_pimpinan;
    #[Validate('required|email')]
    public $email_pimpinan;
    #[Validate('required')]
    public $nik;
    #[Validate('required')]
    public $no_hp;
    #[Validate('required|image')]
    public $scan_ktp;
    #[Validate('required')]
    public $alamat_pimpinan;

    public function mount(){
        $this->propinsis = Propinsi::all();
        $this->all_kabkotas = KabKota::all();
        $this->all_kecamatans = Kecamatan::all();
        $this->all_kelurahans = Kelurahan::all();
        
        $this->skpd = Skpd::all();
        $this->all_urusan = UrusanSkpd::all();
    }
    
    public function render()
    {
        return view('livewire.lembaga.create');
    }
    
    public function updatedIdSkpd($value){
        $this->urusan = collect($this->all_urusan)->where('id_skpd', $value)->values()->toArray();
    }
    
    public function updatedPropinsi($value){
        $this->kabkotas = collect($this->all_kabkotas)->where('id_propinsi', $value)->values()->toArray();
    }

    public function updatedKabkota($value){
        $this->kecamatans = collect($this->all_kecamatans)->where('id_kabkota', $value)->values()->toArray();
    }

    public function updatedKecamatan($value){
        $this->kelurahans = collect($this->all_kelurahans)->where('id_kecamatan', $value)->values()->toArray();
    }

    public function store(){
        $this->validate();

        DB::beginTransaction();
        
        $ext_photo = $this->photo->getclientOriginalExtension();
        $photo_path = $this->photo->storeAs('data_lembaga', 'lembaga_' . Auth::user()->id . '_photo.' . $ext_photo, 'public');
        
        $ext_akta_kumham = $this->file_akta_kumham->getclientOriginalExtension();
        $akta_kumham_path = $this->file_akta_kumham->storeAs('data_lembaga', 'lembaga_' . Auth::user()->id . '_akta_kumham.' . $ext_akta_kumham, 'public');
        
        $ext_file_domisili = $this->file_domisili->getclientOriginalExtension();
        $file_domisili_path = $this->file_domisili->storeAs('data_lembaga', 'lembaga_' . Auth::user()->id . '_file_domisili.' . $ext_file_domisili, 'public');
        
        $ext_operasional = $this->file_operasional->getclientOriginalExtension();
        $operasional_path = $this->file_operasional->storeAs('data_lembaga', 'lembaga_' . Auth::user()->id . '_operasional.' . $ext_operasional, 'public');
        
        $ext_pernyataan = $this->file_pernyataan->getclientOriginalExtension();
        $pernyataan_path = $this->file_pernyataan->storeAs('data_lembaga', 'lembaga_' . Auth::user()->id . '_pernyataan.' . $ext_pernyataan, 'public');
        
        $ext_scan_ktp = $this->scan_ktp->getclientOriginalExtension();
        $scan_ktp_path = $this->scan_ktp->storeAs('pengurus', 'pimpinan_'. $this->acronym . Auth::user()->id . '_scan_ktp.' . $ext_scan_ktp, 'public');


        try {
            $lembaga = Lembaga::create([
                'name' => $this->name_lembaga,
                'acronym' => $this->acronym,
                'email' => $this->email,
                'phone' => $this->phone,
                'id_skpd' => $this->id_skpd,
                'id_urusan' => $this->id_urusan,
                'kelurahan' => $this->kelurahan,
                'alamat' => $this->alamat,
                'photo' => $photo_path,
                'npwp' => $this->npwp,
                'no_akta_kumham' => $this->no_akta_kumham,
                'date_akta_kumham' => $this->date_akta_kumham,
                'file_akta_kumham' => $akta_kumham_path,
                'no_domisili' => $this->no_domisili,
                'date_domisili' => $this->date_domisili,
                'file_domisili' => $file_domisili_path,
                'no_operasional' => $this->no_operasional,
                'date_operasional' => $this->date_operasional,
                'file_operasional' => $operasional_path,
                'no_pernyataan' => $this->no_pernyataan,
                'date_pernyataan' => $this->date_pernyataan,
                'file_pernyataan' => $pernyataan_path,
            ]);
            
            $pengurus = $lembaga->pengurus()->create([
                'name' => $this->name_pimpinan,
                'email' => $this->email_pimpinan,
                'nik' => $this->nik,
                'no_hp' => $this->no_hp,
                'alamat' => $this->alamat_pimpinan,
                'scan_ktp' => $scan_ktp_path,
            ]);

            $user = User::findOrFail(Auth::user()->id)->update([
                'id_skpd' => $this->id_skpd,
                'id_urusan' => $this->id_urusan,
                'id_lembaga' => $lembaga->id,
            ]);

            $data_lembaga = ['lembaga' => $lembaga->toArray(), 'pengurus' => $pengurus->toArray()];

            ActivityLogService::log('lembaga.create', 'success', 'tambah data lembaga dan pengurus', json_encode($data_lembaga));

            DB::commit();

            return redirect()->route('lembaga.admin', ['id_lembaga' => $lembaga->id])->with('success', 'Lembaga created successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();

            if(Storage::disk('public')->exists($photo_path)){
                Storage::disk('public')->delete($photo_path);
            }
            if(Storage::disk('public')->exists($akta_kumham_path)){
                Storage::disk('public')->delete($akta_kumham_path);
            }
            if(Storage::disk('public')->exists($file_domisili_path)){
                Storage::disk('public')->delete($file_domisili_path);
            }
            if(Storage::disk('public')->exists($operasional_path)){
                Storage::disk('public')->delete($operasional_path);
            }
            if(Storage::disk('public')->exists($pernyataan_path)){
                Storage::disk('public')->delete($pernyataan_path);
            }
            if(Storage::disk('public')->exists($scan_ktp_path)){
                Storage::disk('public')->delete($scan_ktp_path);
            }

            session()->flash('error', 'Gagal menyimpan data: ' . $th->getMessage());
        }
    }
}
