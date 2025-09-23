<?php

namespace App\Livewire;

use App\Models\Permission as ModelsPermission;
use App\Services\UserLogService;
use App\Traits\WithAuthorization;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Auth\Access\Authorizable;
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
        return $this->authorizeAction('viewAny', ModelsPermission::class) ?? null;
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

        ModelsPermission::create([
            'name' => ucwords($this->name),
            'guard_name' => $this->guard_name,
        ]);

        new UserLogService('create', 'create permission '.$this->name);

        $this->reset(['name', 'guard_name']);
        session()->flash('success', 'Permission created successfully.');
        $this->dispatch('closeModal');
    }

    public function saveAndMore(){
        $this->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'guard_name' => 'required|string|max:255',
        ]);

        ModelsPermission::create([
            'name' => ucwords($this->name),
            'guard_name' => $this->guard_name,
        ]);

        new UserLogService('create', 'tambah permission '.$this->name);

        $this->reset(['name', 'guard_name']);
    }

    public function edit($id){
        $permission = ModelsPermission::findOrFail($id);
        $this->name = $permission->name;
        $this->guard_name = $permission->guard_name;

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

        new UserLogService('update', 'pembaruan permission '.$this->name);

        $this->reset(['name', 'guard_name']);
        $this->dispatch('closeModal');
    }
}
