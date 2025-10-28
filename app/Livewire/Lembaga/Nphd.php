<?php

namespace App\Livewire\Lembaga;

use App\Models\Lembaga;
use Livewire\Component;

class Nphd extends Component
{
    public $lembaga;

    public $nomor_pengukuhan;
    public $tanggal_pengukuhan;
    public $tentang_pengukuhan;
    public $pemberi_amanat;
    public $masa_bakti;
    public $deskripsi;
    public $uraian = [];

    public function mount($id_lembaga){
        $this->lembaga = Lembaga::findOrFail($id_lembaga);
        if($this->lembaga){

        }
        $this->uraian = [
            [
                'uraian' => ''
            ]
        ];
    }

    public function render()
    {
        return view('livewire.lembaga.nphd');
    }

    public function tambahUraian(){
        $count_uraian = count($this->uraian);
        $this->uraian[$count_uraian + 1] = [
            'uraian' => ''
        ];
    }
}
