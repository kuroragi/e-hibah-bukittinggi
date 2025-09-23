<?php

namespace App\Livewire\Lembaga;

use App\Models\Bank;
use App\Models\Lembaga;
use App\Services\UserLogService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class Pendukung extends Component
{
    use WithFileUploads;

    public $banks;
    public $lembaga;

    public $id_lembaga;
    public $no_domisili;
    public $date_domisili;
    public $file_domisili;
    public $no_operasional;
    public $date_operasional;
    public $file_operasional;
    public $id_bank;
    public $atas_nama;
    public $no_rek;
    public $photo_rek;

    public function mount($id_lembaga = null) {
        $lembaga = Lembaga::findOrFail($id_lembaga);
        if($lembaga){
            $this->lembaga = $lembaga;
            $this->id_lembaga = $lembaga->id;
            $this->no_domisili = $lembaga->no_domisili;
            $this->date_domisili = $lembaga->date_domisili;
            $this->file_domisili = $lembaga->file_domisili;
            $this->no_operasional = $lembaga->no_operasional;
            $this->date_operasional = $lembaga->date_operasional;
            $this->file_operasional = $lembaga->file_operasional;
            $this->id_bank = $lembaga->id_bank;
            $this->atas_nama = $lembaga->atas_nama;
            $this->no_rek = $lembaga->no_rekening;
            $this->photo_rek = $lembaga->photo_rek;
        }

        $this->banks = Bank::orderBy('acronym')->get();
    }

    public function render()
    {
        return view('livewire.lembaga.pendukung');
    }

    public function rules()
    {
        return [
            'photo_rek' => $this->photo_rek instanceof TemporaryUploadedFile
                ? 'required|image'
                : 'nullable|string',
        ];
    }

    public function update() {
        $this->validate();
        
        DB::beginTransaction();

        if(!Storage::disk('public')->exists($this->photo_rek)){
            $ext_photo_rek = $this->photo_rek->getclientOriginalExtension();
            $photo_rek_path = $this->photo_rek->storeAs('data_lembaga', 'lembaga_' . Auth::user()->id . '_photo_rek.' . $ext_photo_rek, 'public');
        }else{
            $photo_rek_path = $this->photo_rek;
        }

        try {
            $pendukung = Lembaga::findOrFail($this->id_lembaga)->update([
                'no_domisili' => $this->no_domisili,
                'date_domisili' => $this->date_domisili,
                'file_domisili' => $this->file_domisili,
                'no_operasional' => $this->no_operasional,
                'date_operasional' => $this->date_operasional,
                'file_operasional' => $this->file_operasional,
                'id_bank' => $this->id_bank,
                'atas_nama' => $this->atas_nama,
                'no_rekening' => $this->no_rek,
                'photo_rek' => $photo_rek_path,
            ]);

            new UserLogService('update', 'Pembaruan data pendukung lembaga '.$this->lembaga->name);

            DB::commit();

            return redirect()->route('lembaga.admin', ['id_lembaga' => $this->id_lembaga]);
        } catch (\Throwable $th) {
            DB::rollBack();

            if(Storage::disk('public')->exists($photo_rek_path)){
                Storage::disk('public')->delete($photo_rek_path);
            }

            return session()->flash('error', 'Gagal mengupdate data pendukung, karena: '.$th->getMessage());
        }
    }
}
