<?php

namespace App\Livewire;

use App\Models\Permission;
use App\Models\Role as ModelsRole;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Role extends Component
{
    public $roles;
    public $permissions = [];
    public $selectedPermissions = [];

    public $roleId;
    public $name;
    public $guard_name;
    
    protected $listeners = [
        'editRole',
        'deleteModal',
        'closeModal'
    ];
    // protected $listeners = ['select2Updated' => 'updateSelectedPermissions'];

    public function mount()
    {
        $this->permissions = Permission::orderBy('name', 'ASC')->get(); // Assuming you have a Permission model
    }

    public function render()
    {
        $this->roles = ModelsRole::orderBy('id', 'ASC')->get(); // Assuming you have a Role model
        return view('livewire.pages.role');
    }

    #[On('select2-updated')]
    public function updateSelectedPermissions($data)
    {
        $this->selectedPermissions = $data;
    }

    public function save(){
        $this->validate([
            'name' => 'required|string|max:255',
            'guard_name' => 'required|string|max:255',
            'selectedPermissions' => 'array',
        ]);

        ModelsRole::create([
            'name' => $this->name,
            'guard_name' => $this->guard_name,
        ])->syncPermissions($this->selectedPermissions);

        session()->flash('message', 'Role created successfully.');
        $this->reset(['name', 'guard_name', 'selectedPermissions']);
    }

    public function edit($roleId)
    {
        $role = ModelsRole::findOrFail($roleId);

        $this->roleId = $role->id;
        $this->name = $role->name;
        $this->guard_name = $role->guard_name;
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();

        // buka modal setelah data siap
        $this->dispatch('editRole');
    }

    public function updateRole()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'guard_name' => 'required|string',
            'selectedPermissions' => 'array',
        ]);

        $role = ModelsRole::findOrFail($this->roleId);
        $role->update([
            'name' => $this->name,
            'guard_name' => $this->guard_name,
        ]);

        $role->syncPermissions($this->selectedPermissions);

        $this->reset(['roleId', 'name', 'guard_name', 'selectedPermissions']);
        session()->flash('message', 'Role berhasil diperbarui.');
        $this->dispatch('closeModal');
    }

    public function delete_warning($id_role){
        $role = ModelsRole::findOrFail($id_role);
        if($role){
            $this->roleId = $role->id;
            $this->name = $role->name;
            $this->guard_name = $role->guard_name;
            $this->selectedPermissions = $role->permissions->pluck('name')->toArray();

            $this->dispatch('deleteModal');
        }
    }

    public function delete($id_role){
        $role = ModelsRole::findOrFail($id_role);
        if($role){
            DB::beginTransaction();

            try {
                
                $role->permissions()->detach();

                $role->delete();

                DB::commit();

                $this->dispatch('closeModal');
            } catch (\Throwable $th) {
                DB::rollBack();
                dd($th);
                session()->flash("Error", "Gagal menghapus data: ", $th->getMessage());
            }
        }
    }
}
