<?php

namespace App\Livewire\Lembaga;

use App\Models\KabKota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Lembaga;
use App\Models\Propinsi;
use App\Models\Skpd;
use App\Models\UrusanSkpd;
use App\Services\ActivityLogService;
use App\Services\UserLogService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Profile extends Component
{
    public $skpd;
    public $urusan;
    public $propinsis = [];
    public $all_kabkotas = [];
    public $kabkotas = [];
    public $all_kecamatans = [];
    public $kecamatans = [];
    public $all_kelurahans = [];
    public $kelurahans = [];
    
    public $id_lembaga;
    #[Validate('required')]
    public $name;
    #[Validate('required')]
    public $id_urusan;
    #[Validate('required')]
    public $id_skpd;
    #[Validate('required')]
    public $email;
    #[Validate('required')]
    public $phone;
    public $propinsi;
    public $kabkota;
    public $kecamatan;
    public $kelurahan;
    #[Validate('required')]
    public $alamat;

    public $listeners = [
        'updatedPropinsi' => 'updatedPropinsi',
        'updatedKabkota' => 'updatedKabkota',
        'updatedKecamatan' => 'updatedKecamatan',
    ];

    public function mount($id_lembaga = null){
        
        $this->propinsis = Propinsi::all();
        $this->all_kabkotas = KabKota::all();
        $this->all_kecamatans = Kecamatan::all();
        $this->all_kelurahans = Kelurahan::all();

        if($lembaga = Lembaga::findOrFail($id_lembaga)){
            $this->id_lembaga = $lembaga->id;
            $this->name = $lembaga->name;
            $this->id_skpd = $lembaga->id_skpd;
            $this->id_urusan = $lembaga->id_urusan;
            $this->email = $lembaga->email;
            $this->phone = $lembaga->phone;
            $this->kelurahan = $lembaga->id_kelurahan;
            $this->kecamatan = $this->getKelurahan($this->kelurahan)->id_kecamatan ?? null;
            $this->kabkota = $this->getKecamatan($this->kecamatan)->id_kabkota ?? null;
            $this->propinsi = $this->getKabkota($this->kabkota)->id_propinsi ?? null;
            $this->alamat = $lembaga->alamat;
        }
        $this->updatedPropinsi();
        $this->updatedKabkota();
        $this->updatedKecamatan();
        $this->skpd = Skpd::all();
        $this->urusan = UrusanSkpd::all();
    }

    public function render()
    {
        return view('livewire.lembaga.profile');
    }

    public function updatedPropinsi(){
        $this->kabkotas = collect($this->all_kabkotas)->where('id_propinsi', $this->propinsi)->values()->toArray();
    }

    public function updatedKabkota(){
        $this->kecamatans = collect($this->all_kecamatans)->where('id_kabkota', $this->kabkota)->values()->toArray();
    }

    public function updatedKecamatan(){
        $this->kelurahans = collect($this->all_kelurahans)->where('id_kecamatan', $this->kecamatan)->values()->toArray();
    }

    public function getKelurahan($id_kelurahan){
        return Kelurahan::find($id_kelurahan);
    }

    public function getKecamatan($id_kecamatan){
        return Kecamatan::find($id_kecamatan);
    }

    public function getKabkota($id_kabkota){
        return Kabkota::find($id_kabkota);
    }

    public function update(){
        $this->validate();

        DB::beginTransaction();
        try {
            $profil = Lembaga::findOrFail($this->id_lembaga)->update([
                'name' => $this->name,
                'id_skpd' => $this->id_skpd,
                'id_urusan' => $this->id_urusan,
                'email' => $this->email,
                'phone' => $this->phone,
                'id_kelurahan' => $this->kelurahan,
                'alamat' => $this->alamat,
            ]);

            ActivityLogService::log('lembaga.update-profil', 'warning', 'Pembaruan data profil lembaga '.$this->name, json_encode($profil->toArray()));

            DB::commit();
            
            return redirect()->route('lembaga.admin', ['id_lembaga' => $this->id_lembaga])->with('success', 'Profil lembaga berhasil diperbarui.');
        } catch (\Throwable $th) {
            DB::rollBack();

            return session()->flash('error', 'gagal update profil, karena: '.$th->getMessage());
        }

    }
}
