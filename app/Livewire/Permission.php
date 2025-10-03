<?php

namespace App\Livewire;

use App\Models\Permission as ModelsPermission;
use App\Services\ActivityLogService;
use App\Services\UserLogService;
use App\Traits\WithAuthorization;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Permission extends Component
{
    use WithAuthorization;

    public $name;
    public $guard_name;
    public $permissions;

    protected $listeners = ['editmore', 'editPermission', 'closeModal'];
    public function mount()
    {
        $this->authorizeAction('viewAny', ModelsPermission::class) ?? null;
    }

    public function render()
    {
        $this->permissions = ModelsPermission::all();
        return view('livewire.pages.permission');
    }

    public function save(){
        $this->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'guard_name' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $permission = ModelsPermission::create([
                'name' => ucwords($this->name),
                'guard_name' => $this->guard_name,
            ]);

            DB::commit();
    
            ActivityLogService::log('permission.create', 'success', 'penambahan data permission '.$this->name, json_encode($permission->toArray()));
    
            $this->reset(['name', 'guard_name']);
            session()->flash('success', 'Permission created successfully.');
            $this->dispatch('closeModal');
        } catch (\Throwable $th) {
            DB::rollBack();

            session()->flash('error', 'gagal menambahkan permission, karena: '.$th->getMessage());
        }
    }

    public function saveAndMore(){
        $this->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'guard_name' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try{

            $permission = ModelsPermission::create([
                'name' => ucwords($this->name),
                'guard_name' => $this->guard_name,
            ]);

            DB::commit();

            ActivityLogService::log('permission.update', 'success', 'penambahan data permission '.$this->name, json_encode($permission->toArray()));

            $this->reset(['name', 'guard_name']);
        }catch(\Throwable $th){
            DB::rollBack();

            session()->flash('error', 'gagal menambahkan permission, karena: '.$th->getMessage());
        }
    }

    public function edit($id){
        $permission = ModelsPermission::findOrFail($id);
        $this->name = $permission->name;
        $this->guard_name = $permission->guard_name;

        ActivityLogService::log('permission.edit', 'info', 'edit data permission '.$this->name, json_encode($permission->toArray()));

        $this->dispatch('editPermission');
    }

    public function update($id){
        $this->validate([
            'name' => 'required|string',
            'guard_name' => 'required',
        ]);

        $permission = ModelsPermission::findOrFail($id);
        $permission->update([
            'name' => ucwords($this->name),
            'guard_name' => $this->guard_name,
        ]);

        ActivityLogService::log('permission.update', 'warning', 'perubahan data permission '.$this->name, json_encode($permission->toArray()));


        $this->reset(['name', 'guard_name']);
        $this->dispatch('closeModal');
    }
}
