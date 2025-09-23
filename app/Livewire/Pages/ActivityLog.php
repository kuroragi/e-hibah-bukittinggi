<?php

namespace App\Livewire\Pages;

use App\Services\ActivityLogService;
use Livewire\Component;

class ActivityLog extends Component
{
    public $week;
    public $logs = [];
    public $userId;


    protected $queryString = ['week', 'userId'];


    public function mount()
    {
        $this->week = $this->week ?? now()->format('o-\WW');
        $this->loadLogs();
    }

    public function loadLogs()
    {
        $service = app(ActivityLogService::class);
        $logs = $service->read($this->week);
        if ($this->userId) {
        $logs = array_filter($logs, fn($log) => $log['user_id'] == $this->userId);
        }
        $this->logs = $logs;
    }

    public function render()
    {
        return view('livewire.pages.activity-log');
    }
}
