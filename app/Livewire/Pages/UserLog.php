<?php

namespace App\Livewire\Pages;

use App\Models\UserLog as ModelsUserLog;
use Livewire\Component;
use Livewire\WithPagination;

class UserLog extends Component
{
    use WithPagination;

    public function render()
    {
        $logs = ModelsUserLog::select('id','id_user','action','description','ip_address','created_at')->with(['user:id,name'])
            ->latest()
            ->paginate(100);

        return view('livewire.pages.user-log', [
            'logs' => $logs
        ]);
    }
}
