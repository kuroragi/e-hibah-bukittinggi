<?php

namespace App\Livewire;

use App\Imports\QuestionsImport;
use App\Models\PertanyaanKelengkapan as ModelsPertanyaanKelengkapan;
use App\Traits\WithAuthorization;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class PertanyaanKelengkapan extends Component
{
    use WithFileUploads, WithAuthorization;

    public $file_import;
    
    public $questions;
    public $parents;
    public $orders = [1];

    public $id_pertanyaan;

    #[Validate('required')]
    public $question;
    public $id_parent;
    #[Validate('required')]
    public $order = 1;

    public $listeners = ['import-start', 'import-finish', 'showImportResult', 'updateModal', 'updateOrder', 'closeModal'];

    public function mount(){
        //
    }

    public function render()
    {
        $this->questions = $this->pertanyaan();
        $this->parents = ModelsPertanyaanKelengkapan::where('id_parent', null)->orderBy('order')->get();
        return view('livewire.pertanyaan-kelengkapan');
    }

    public function import()
    {
        $this->validate([
            'file_import' => 'required|file|mimes:xlsx,csv,xls',
        ]);

        // tampilkan loading di frontend
        $this->dispatch('import-start');

        try {
            $import = new QuestionsImport();
            Excel::import($import, $this->file_import);

            // hasil import
            $summary = [
                'total'     => $import->getRowCount(),
                'success'   => $import->getSuccessCount(),
                'failed'    => $import->getFailedCount(),
                'errors'    => $import->getErrors(),
            ];

            // kirim hasil ke JS
            $this->dispatch('import-finished', $summary);

        } catch (\Exception $e) {
            $this->dispatch('import-finished', [
                'total' => 0,
                'success' => 0,
                'failed' => 0,
                'errors' => [$e->getMessage()],
            ]);
        }
    }
    
    #[Computed()]
    public function pertanyaan()
    {
        return ModelsPertanyaanKelengkapan::with(['children' => function($query) {$query->orderBy('order');}])->where('id_parent', null)->orderBy('order')->get();;
    }

    #[On('updateOrder')]
    public function updateOrder(){
        // hitung jumlah record yang sudah ada untuk id_parent ini
        $countOrder = ModelsPertanyaanKelengkapan::where('id_parent', $this->id_parent)->count();

        // total urutan = jumlah record saat ini + 1 (untuk baris baru)
        $total = max(1, $countOrder + 1);

        // set orders menjadi [1,2,3,...,$total]
        $this->orders = range(1, $total);

        $this->order = $this->orders[$total - 1] ?? null;
    }

    public function store(){
        $this->validate();

        ModelsPertanyaanKelengkapan::updateOrCreate([
            'id' => $this->id_pertanyaan
        ],[
            'question' => $this->question,
            'id_parent' => $this->id_parent,
            'order' => $this->order,
        ]);

        $this->reset(['question', 'id_parent', 'order']);
        $this->dispatch('closeModal');
    }

    public function edit($id_pertanyaan){
        $pertanyaan = ModelsPertanyaanKelengkapan::findOrFail($id_pertanyaan);
        $this->id_pertanyaan = $pertanyaan->id;
        $this->question = $pertanyaan->question;
        $this->id_parent = $pertanyaan->id_parent;
        $countOrder = ModelsPertanyaanKelengkapan::where('id_parent', $this->id_parent)->count();

        // total urutan = jumlah record saat ini + 1 (untuk baris baru)
        $total = max(1, $countOrder);

        // set orders menjadi [1,2,3,...,$total]
        $this->orders = range(1, $total);
        $this->order = $pertanyaan->order;

        $this->dispatch('editModal');
    }
}
