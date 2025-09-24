<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RollActivityLogs extends Command
{
    
    protected $signature = 'activity:roll';
    protected $description = 'Compress and clean up old activity logs';

    public function handle()
    {
        $logPath = storage_path('logs/activity');
        $today   = now()->format('Y-m-d');

        foreach (File::files($logPath) as $file) {
            $filename = $file->getFilename();

            if (str_starts_with($filename, "activity-") && str_ends_with($filename, ".log")) {
                $date = str_replace(['activity-', '.log'], '', $filename);

                if ($date !== $today) {
                    if (filesize($file) > 0) {
                        $gzFile = $logPath . "/{$filename}.gz"; // jadi activity-2025-09-24.log.gz
                        $fp     = gzopen($gzFile, 'w9');
                        gzwrite($fp, File::get($file));
                        gzclose($fp);
                    }
                    File::delete($file);
                } elseif (filesize($file) === 0) {
                    File::delete($file);
                }
            }
        }

        $this->info("Activity logs rolled successfully.");
    }

    /**
     * Laravel 12: langsung define schedule di sini
     */
    public function schedule(\Illuminate\Console\Scheduling\Schedule $schedule): void
    {
        $schedule->command(static::class)->dailyAt('00:05');
    }
}
