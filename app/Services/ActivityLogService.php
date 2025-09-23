<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\LazyCollection;

class ActivityLogService{
    protected string $logPath;

    public function __construct() {
        $this->logPath = config('activitylog.path', storage_path('logs/activity'));
        if(!File::exists($this->logPath)){
            File::makeDirectory($this->logPath, 0755, true);
        }
    }

    protected function weekFilenameForDate(?Carbon $date = null): string
    {
        $date = $date ?: Carbon::now();
        // week start: Monday (default) or Sunday if configured
        $startOfWeek = (config('activitylog.week_start', 'monday') === 'sunday')
            ? $date->copy()->startOfWeek(Carbon::SUNDAY)
            : $date->copy()->startOfWeek(Carbon::MONDAY);
        $endOfWeek = $startOfWeek->copy()->endOfWeek();
        $file = sprintf('%s/%s%s_to_%s.log',
            $this->logPath,
            config('activitylog.file_prefix', 'activity-'),
            $startOfWeek->format('Y-m-d'),
            $endOfWeek->format('Y-m-d')
        );
        return $file;
    }

    protected function normalizeUser($user)
    {
        if (!$user) return null;
        if (is_array($user)) return $user;
        if (is_object($user)) {
            // try common fields
            return [
                'id'    => $user->id ?? null,
                'name'  => $user->name ?? null,
                'role'  => $user->roles()->pluck('name')->toArray()[0] ?? null,
            ];
        }
        return ['identifier' => $user];
    }

    /**
     * Tulis entry log sebagai JSON newline (JSONL).
     *
     * @param string $action  // mis. 'user.created' atau 'order.paid'
     * @param mixed $description // array/string/object - dijadikan JSON
     * @param mixed $user // user model atau array atau null
     * @param string $level // info, warning, error
     * @param array $meta  // tambahan bebas
     * @return bool
     */
    public function log(string $event, string $level = 'info', string $description): void {
        $entry = [
            'timestamp' => now()->toIso8601String(),
            'event' => $event,
            'level' => $level,
            'user' => $this->normalizeUser(Auth::user()),
            'meta' => [
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'description' => $description,
            ]
        ];

        $json = json_encode($entry, JSON_UNESCAPED_UNICODE);

        $file = $this->weekFilenameForDate();

        // safe append with lock
        $fp = fopen($file, 'a');
        if ($fp === false) return;
        flock($fp, LOCK_EX);
        fwrite($fp, $json . PHP_EOL);
        fflush($fp);
        flock($fp, LOCK_UN);
        fclose($fp);
    }

    /**
     * List semua file minggu yang tersedia (basename)
     * @return array
     */
    public function listWeekFiles(): array
    {
        $files = glob($this->logPath . '/' . config('activitylog.file_prefix', 'activity-') . '*.log') ?: [];
        // sort newest first by filename (dates in name)
        usort($files, function ($a, $b) {
            return filemtime($b) <=> filemtime($a);
        });
        return array_map('basename', $files);
    }

    /**
     * Ambil entries dari file (basename), support pagination sederhana.
     *
     * @param string $basename
     * @param int $page
     * @param int $perPage
     * @return array ['data' => [], 'total' => int, 'current_page'=>, 'last_page'=>]
     */
    public function getEntriesByBasename(string $basename, int $page = 1, int $perPage = 50): array
    {
        $basename = basename($basename);
        $file = $this->logPath . '/' . $basename;
        if (!file_exists($file)) {
            return ['data' => [], 'total' => 0, 'current_page' => 1, 'last_page' => 1];
        }

        // LazyCollection untuk memory-efficient read
        $lines = LazyCollection::make(function () use ($file) {
            $handle = fopen($file, 'r');
            if (!$handle) return;
            while (!feof($handle)) {
                $line = fgets($handle);
                if ($line !== false) yield $line;
            }
            fclose($handle);
        })->map(function ($line) {
            $decoded = json_decode($line, true);
            return $decoded ?: null;
        })->filter();

        $total = $lines->count();
        $slice = $lines->forPage($page, $perPage)->values()->all();

        $lastPage = (int) max(1, ceil($total / $perPage));
        return [
            'data' => $slice,
            'total' => $total,
            'current_page' => $page,
            'last_page' => $lastPage,
        ];
    }

    /**
     * Hapus file yang usianya lebih tua dari $weeks (default config)
     */
    // public function cleanupOld(int $weeks = null): int
    // {
    //     $weeks = $weeks ?: config('activitylog.retention_weeks', 12);
    //     $files = glob($this->path . '/' . config('activitylog.file_prefix', 'activity-') . '*.log') ?: [];
    //     $deleted = 0;
    //     $threshold = Carbon::now()->subWeeks($weeks);
    //     foreach ($files as $file) {
    //         // parsing tanggal dari nama file atau gunakan filemtime
    //         if (filemtime($file) < $threshold->timestamp) {
    //             @unlink($file);
    //             $deleted++;
    //         }
    //     }
    //     return $deleted;
    // }

    public function read(string $week): array
    {
        $file = $this->logPath."/{$week}.jsonl";
        if (!File::exists($file)) return [];
        return array_map('json_decode', file($file), array_fill(0, count(file($file)), true));
    }


    public function readRange(string $from, string $to, ?int $userId = null): array
    {
        $start = Carbon::parse($from);
        $end = Carbon::parse($to);
        $logs = [];


        for ($date = $start; $date->lte($end); $date->addWeek()) {
        $week = $date->format('o-\WW');
        $weekly = $this->read($week);
        if ($userId) {
        $weekly = array_filter($weekly, fn($log) => $log['user_id'] == $userId);
        }
        $logs = array_merge($logs, $weekly);
        }


        return $logs;
    }


    public function exportRange(string $from, string $to, ?int $userId = null, string $format = 'json'): string
    {
        $logs = $this->readRange($from, $to, $userId);
        $filename = "activity-{$from}_{$to}.{$format}";
        $path = $this->logPath.'/'.$filename;


        if ($format === 'json') {
        File::put($path, json_encode($logs, JSON_PRETTY_PRINT));
        } elseif ($format === 'csv') {
        $f = fopen($path, 'w');
        fputcsv($f, array_keys($logs[0] ?? []));
        foreach ($logs as $log) {
        fputcsv($f, $log);
        }
        fclose($f);
        }


        return $path;
    }
}