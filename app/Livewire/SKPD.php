<?php

namespace App\Livewire;

use App\Models\Skpd as ModelsSkpd;
use App\Models\UrusanSkpd;
use App\Services\ActivityLogService;
use App\Services\UserLogService;
use App\Traits\WithAuthorization;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SKPD extends Component
{
    use WithAuthorization;
    public $skpds;
    public $skpd;

    #[Validate('required')]
    public $name;
    #[Validate('required')]
    public $deskripsi;
    #[Validate('required')]
    public $alamat;
    public $telp;
    public $email;
    public $fax;
    public $urusan_skpd = [];
    public $count_urusan = 0;

    protected $listeners = ['createModal', 'editModal', 'deleteModal', 'closeModal', 'verifyingDelete'];

    public function mount(){
        
        $this->authorizeAction('viewAny', ModelsSkpd::class) ?? null;
    }

    public function addUrusan()
    {
        $this->urusan_skpd[] = ['nama_urusan' => ''];
    }

    public function removeUrusan($index)
    {
        unset($this->urusan_skpd[$index]);
        $this->urusan_skpd = array_values($this->urusan_skpd); // Re-index the array
    }

    public function render()
    {
        $this->skpds = ModelsSkpd::with(['has_urusan'])->orderBy('id', 'ASC')->get(); // Assuming you have a Skpd model
        return view('livewire.skpd');
    }

    public function create(){
        $this->reset(['skpd', 'name', 'urusan_skpd']);
        $this->dispatch('createModal');
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        DB::transaction(function () {
            $skpd = ModelsSkpd::create([
                'name' => $this->name,
                'deskripsi' => $this->deskripsi,
                'alamat' => $this->alamat,
                'telp' => $this->telp,
                'email' => $this->email,
                'fax' => $this->fax,
            ]);

            $skpdArray = ['name' => $this->name];

            foreach ($this->urusan_skpd as $key => $urusan) {
                if (!empty($urusan['nama_urusan'])) {
                    $skpd->has_urusan()->create([
                        'nama_urusan' => $urusan['nama_urusan'],
                    ]);
                }

                $skpdArray['urusan'][$key] = $urusan['nama_urusan'];
            }

            ActivityLogService::log('skpd.create', 'success', 'penambahan data skpd '.$this->name.' dan urusan terkait', json_encode($skpdArray));
        });

        $this->reset(['name', 'urusan_skpd']);
        session()->flash('message', 'SKPD created successfully.');
        $this->dispatch('closeModal');
    }

    public function edit($id){
        $this->skpd = ModelsSkpd::with(['has_urusan'])->findOrFail($id);
        $this->name = $this->skpd->name;
        $this->deskripsi = $this->skpd->deskripsi;
        $this->alamat = $this->skpd->alamat;
        $this->telp = $this->skpd->telp;
        $this->email = $this->skpd->email;
        $this->fax = $this->skpd->fax;
        $this->urusan_skpd = $this->skpd->has_urusan->toArray();
        $this->count_urusan = count($this->urusan_skpd);
        $this->dispatch('editModal');
    }

    public function update()
    {
        $this->validate();

        DB::transaction(function () {
            $this->skpd->update([
                'name' => $this->name,
                'deskripsi' => $this->deskripsi,
                'alamat' => $this->alamat,
                'telp' => $this->telp,
                'email' => $this->email,
                'fax' => $this->fax,
            ]);

            // Ambil semua ID urusan lama dari DB
        $existingIds = $this->skpd->has_urusan()->pluck('id')->toArray();

        // Ambil semua ID dari input
        $idsToDelete = $this->skpd->has_urusan()
            ->whereNotIn('id', collect($this->urusan_skpd)->pluck('id')->filter())
            ->pluck('id')->toArray();
            
        $this->deleteUrusanByIds($idsToDelete);

        // 2. Update urusan lama & buat yang baru
        foreach ($this->urusan_skpd as $urusan) {
            if (isset($urusan['id']) && in_array($urusan['id'], $existingIds)) {
                // Update data lama
                UrusanSkpd::where('id', $urusan['id'])->update([
                    'nama_urusan' => $urusan['nama_urusan'],
                ]);
            } else {
                // Data baru → insert
                $this->skpd->has_urusan()->create([
                        'nama_urusan' => $urusan['nama_urusan'],
                    ]);
            }
        }
        });

        ActivityLogService::log('skpd.update', 'warning', 'pembaruan data skpd '.$this->name.' dan urusan terkait', json_encode($this->skpd->toArray()));

        session()->flash('message', 'SKPD updated successfully.');
        $this->dispatch('closeModal');
    }

    public function verifyDelete($id){
        $this->skpd = ModelsSkpd::with(['has_urusan'])->where('id', $id)->first();
        $this->dispatch('deleteModal');
    }

    public function delete()
    {
        $urusans = $this->skpd->has_urusan()->pluck('id')->toArray();
        DB::beginTransaction();

        try {
            $this->deleteUrusanByIds($urusans);

            $this->skpd->delete();
    
            ActivityLogService::log('skpd.delete', 'danger', 'penghapusan data skpd '.$this->name.' dan urusan terkait', json_encode($this->skpd->toArray()));

            DB::commit();

            $this->reset(['skpd']);
            session()->flash('message', 'SKPD deleted successfully.');
            $this->dispatch('closeModal');
        } catch (\Throwable $th) {
            DB::rollBackk();
            session()->flash('error', 'SKPD gagal di hapus, karena: '.$th->getMessage());
        }

    }

    public function deleteUrusanByIds(array $ids){
        $deleteable_urusan = UrusanSkpd::whereIn('id', $ids)->get();
        UrusanSkpd::whereIn('id', $ids)->delete();

        ActivityLogService::log('urusan_skpd.delete', 'danger', 'hapus data urusan skpd '.$this->name, json_encode($deleteable_urusan->toArray()));
    }
}
