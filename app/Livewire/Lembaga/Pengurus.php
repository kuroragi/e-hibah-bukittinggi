<?php

namespace App\Livewire\Lembaga;

use App\Models\Lembaga;
use App\Models\Pengurus as ModelsPengurus;
use App\Services\UserLogService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class Pengurus extends Component
{
    use WithFileUploads;

    public $id_lembaga;
    public $lembaga;
    public $pengurus;
    public $jumlah_pengurus = 3;

    public function mount($id_lembaga = null) {
        $lembaga = Lembaga::with(['pengurus'])->where('id', $id_lembaga)->first();
        if($lembaga){
            $this->id_lembaga = $lembaga->id;
            $this->lembaga = $lembaga;
            $pengurusCount = $lembaga->pengurus->count();
            if($pengurusCount == 3){
                foreach ($lembaga->pengurus as $key => $_pengurus) {
                    $this->pengurus[$key] = [
                        'id' => $_pengurus->id,
                        'id_lembaga' => $_pengurus->id_lembaga,
                        'name' => $_pengurus->name,
                        'jabatan' => $_pengurus->jabatan,
                        'nik' => $_pengurus->nik,
                        'no_hp' => $_pengurus->no_hp,
                        'email' => $_pengurus->email,
                        'alamat' => $_pengurus->alamat,
                        'scan_ktp' => $_pengurus->scan_ktp,
                    ];
                }
            }else if($pengurusCount < 3){
                for ($key=0; $key < $this->jumlah_pengurus; $key++) { 
                    if(!empty($lembaga->pengurus[$key])){
                        $this->pengurus[$key] = [
                            'id' => $lembaga->pengurus[$key]['id'],
                            'id_lembaga' => $lembaga->pengurus[$key]['id_lembaga'],
                            'name' => $lembaga->pengurus[$key]['name'],
                            'jabatan' => $lembaga->pengurus[$key]['jabatan'],
                            'nik' => $lembaga->pengurus[$key]['nik'],
                            'no_hp' => $lembaga->pengurus[$key]['no_hp'],
                            'email' => $lembaga->pengurus[$key]['email'],
                            'alamat' => $lembaga->pengurus[$key]['alamat'],
                            'scan_ktp' => $lembaga->pengurus[$key]['scan_ktp'],
                        ];
                    }else{
                        $jabatan = '';
                        if($key == 1){
                            $jabatan = 'Sekretaris';
                        }else if($key == 2){
                            $jabatan = 'Bendahara';
                        }
                        $this->pengurus[$key] = [
                            'id' => '',
                            'id_lembaga' => $lembaga->id,
                            'name' => '',
                            'jabatan' => $jabatan,
                            'nik' => '',
                            'no_hp' => '',
                            'email' => '',
                            'alamat' => '',
                            'scan_ktp' => '',
                        ];
                    }
                }
            }
        }
    }
    
    public function render()
    {
        return view('livewire.lembaga.pengurus');
    }

    public function store(){
        DB::beginTransaction();
        
        if ($this->pengurus[0]['scan_ktp'] instanceof TemporaryUploadedFile) {
            $ext_0 = $this->pengurus[0]['scan_ktp']->getClientOriginalExtension();
            $this->pengurus[0]['scan_ktp'] = $this->pengurus[0]['scan_ktp']->storeAs(
                'pengurus',
                'pimpinan_' . $this->lembaga->acronym . Auth::user()->id . '_scan_ktp.' . $ext_0,
                'public'
            );
        }

        if ($this->pengurus[1]['scan_ktp'] instanceof TemporaryUploadedFile) {
            $ext_1 = $this->pengurus[1]['scan_ktp']->getClientOriginalExtension();
            $this->pengurus[1]['scan_ktp'] = $this->pengurus[1]['scan_ktp']->storeAs(
                'pengurus',
                'sekretaris_' . $this->lembaga->acronym . Auth::user()->id . '_scan_ktp.' . $ext_1,
                'public'
            );
        }

        if ($this->pengurus[2]['scan_ktp'] instanceof TemporaryUploadedFile) {
            $ext_2 = $this->pengurus[2]['scan_ktp']->getClientOriginalExtension();
            $this->pengurus[2]['scan_ktp'] = $this->pengurus[2]['scan_ktp']->storeAs(
                'pengurus',
                'bendahara_' . $this->lembaga->acronym . Auth::user()->id . '_scan_ktp.' . $ext_2,
                'public'
            );
        }

        try {
            foreach ($this->pengurus as $key => $item) {
                    ModelsPengurus::updateOrCreate(
                        ['id' => $item['id']],
                        [
                            'id_lembaga' => $item['id_lembaga'],
                            'name' => $item['name'],
                            'jabatan' => $item['jabatan'],
                            'nik' => $item['nik'],
                            'no_hp' => $item['no_hp'],
                            'email' => $item['email'],
                            'alamat' => $item['alamat'],
                            'scan_ktp' => $item['scan_ktp'],
                        ]
                    );
            }

            new UserLogService('update', 'Pembaruan data pengurus lembaga '.$this->lembaga->name);

            DB::commit();

            return redirect()->route('lembaga.admin', ['id_lembaga' => $this->id_lembaga]);
        } catch (\Throwable $th) {
            DB::rollBack();

            foreach ($this->pengurus as $key => $item) {
                if(Storage::disk('public')->exists($item['scan_ktp']) && !$item['id'] == ''){
                    Storage::disk('public')->delete($item['scan_ktp']);
                }
            }

            return session()->flash('error', 'gagal update atau tambah pengurus, karena: '.$th->getMessage());
        }
    }
}
