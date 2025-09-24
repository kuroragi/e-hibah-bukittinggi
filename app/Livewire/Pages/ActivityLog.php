<?php

namespace App\Livewire\Pages;

use Illuminate\Support\Facades\File;
use Livewire\Component;

class ActivityLog extends Component
{
    public $search = '';
    public $dateFilter = null;
    public $logs = [];

    public function mount()
    {
        $this->loadLogs();
    }

    public function updatedSearch()
    {
        $this->loadLogs();
    }

    public function updatedDateFilter()
    {
        $this->loadLogs();
    }

    private function loadLogs()
    {
        $logPath = storage_path('logs/activity');
        $files   = collect(File::files($logPath))
            ->sortByDesc(fn($f) => $f->getCTime());

        $logs = [];
        foreach ($files as $file) {
            $filename = $file->getFilename();
            $date     = str_replace(['activity-', '.log', '.gz'], '', $filename);

            // filter tanggal
            if ($this->dateFilter && $this->dateFilter !== $date) continue;

            $content = str_ends_with($filename, '.gz')
                ? gzdecode(File::get($file))
                : File::get($file);

            foreach (explode("\n", $content) as $line) {
                if (trim($line)) {
                    $data = json_decode($line, true);
                    if ($this->search) {
                        if (!str_contains(strtolower(json_encode($data)), strtolower($this->search))) continue;
                    }
                    $logs[] = $data;
                }
            }
            if (count($logs) >= 50) break;
        }

        $this->logs = array_slice($logs, 0, 50);
    }

    public function render()
    {
        return view('livewire.pages.activity-log');
    }
}
