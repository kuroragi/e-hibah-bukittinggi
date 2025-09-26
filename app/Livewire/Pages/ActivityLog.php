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

        if (!File::exists($logPath)) {
            $this->logs = [];
            return;
        }

        // $files = collect(File::files($logPath))
        //     ->sortByDesc(fn($f) => $f->getCTime());

        $files = collect(File::files($logPath))
            ->filter(fn($f) => str_starts_with($f->getFilename(), 'activity-'))
            ->sortByDesc(fn($f) => $f->getCTime());

        $logs = [];

        foreach ($files as $file) {
            // $filename = $file->getFilename();
            // $date     = str_replace(['activity-', '.log', '.gz'], '', $filename);

            // // filter tanggal
            // if ($this->dateFilter && $this->dateFilter !== $date) continue;

            // $content = str_ends_with($filename, '.gz')
            //     ? gzdecode(File::get($file))
            //     : File::get($file);

            // foreach (explode("\n", $content) as $line) {
            //     if (trim($line)) {
            //         $data = json_decode($line, true);
            //         if ($this->search) {
            //             if (!str_contains(strtolower(json_encode($data)), strtolower($this->search))) continue;
            //         }
            //         $logs[] = $data;
            //     }
            // }
            // if (count($logs) >= 50) break;

            if ($this->dateFilter) {
                $filename = $file->getFilename();
                $date = str_replace(['activity-', '.log', '.gz'], '', $filename);
                if ($date !== $this->dateFilter) continue;
            }

            // ambil isi (support .gz)
            $content = File::get($file);
            if (str_ends_with($file->getFilename(), '.gz')) {
                $content = @gzdecode($content) ?: ''; // suppress if corrupt
            }

            // split baris dengan robust
            $lines = preg_split('/\r\n|\r|\n/', $content);

            foreach ($lines as $line) {
                $line = trim($line);
                if ($line === '') continue;

                $entry = $this->parseLogLine($line);
                if (!$entry) continue; // jika mau skip non-json, ubah parseLogLine agar mengembalikan null

                // search case-insensitive terhadap semua field
                if ($this->search) {
                    $haystack = $this->flattenArrayToString($entry);
                    if (mb_stripos($haystack, $this->search) === false) continue;
                }

                $logs[] = $entry;

                if (count($logs) >= 50) break 2; // sudah cukup
            }
        }

        // urutkan berdasarkan timestamp (desc). gunakan fallback 0 bila timestamp tak valid.
        usort($logs, function ($a, $b) {
            $ta = $this->getTimestampForSort($a);
            $tb = $this->getTimestampForSort($b);
            return $tb <=> $ta;
        });

        $this->logs = array_slice($logs, 0, 50);
    }

    /**
     * Coba parse satu baris log jadi array. Mengembalikan array minimal jika tidak dapat decode JSON.
     * Jika kamu ingin *skip* baris non-json, ubah return menjadi `null`.
     */
    protected function parseLogLine(string $line): ?array
    {
        // 1) Jika baris langsung mulai dengan { atau [, coba decode langsung
        $first = $line[0] ?? '';
        if ($first === '{' || $first === '[') {
            $decoded = json_decode($line, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $decoded;
            }
        }

        // 2) Cari substring JSON (dari { pertama sampai } terakhir)
        $start = strpos($line, '{');
        $end = strrpos($line, '}');
        if ($start !== false && $end !== false && $end > $start) {
            $json = substr($line, $start, $end - $start + 1);
            $decoded = json_decode($json, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $decoded;
            }
        }

        // 3) Coba pola umum "INFO: { ... }"
        if (preg_match('/:\s*(\{.*\})\s*$/s', $line, $m)) {
            $decoded = json_decode($m[1], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $decoded;
            }
        }

        // 4) fallback: ambil timestamp dari prefix [YYYY-MM-DD ...] bila ada
        $timestamp = null;
        if (preg_match('/^\[([^\]]+)\]/', $line, $m2)) {
            $timestamp = $m2[1];
        }

        // Kembalikan struktur minimal (agar UI tidak error). 
        // Jika kamu lebih memilih *skip* baris non-json, return null di sini.
        return [
            'timestamp' => $timestamp ?? now()->toDateTimeString(),
            'event'     => 'raw-log',
            'level'     => 'info',
            'user'      => null,
            'context'   => ['description' => $line],
            'meta'      => [],
            '_raw'      => $line,
        ];
    }

    /**
     * Flatten nested array/object menjadi satu string (digunakan untuk search).
     */
    protected function flattenArrayToString($data): string
    {
        if (is_null($data)) return '';
        if (is_scalar($data)) return (string) $data;

        $out = '';
        array_walk_recursive((array) $data, function ($v) use (&$out) {
            if (is_scalar($v)) $out .= ' ' . $v;
        });

        return trim($out);
    }

    /**
     * Normalisasi timestamp menjadi int (epoch) untuk sorting.
     */
    protected function getTimestampForSort(array $entry): int
    {
        $ts = $entry['timestamp'] ?? null;
        if ($ts) {
            $t = strtotime($ts);
            if ($t !== false) return $t;
            // kalau format lain, coba Carbon (safe)
            try {
                return \Carbon\Carbon::parse($ts)->timestamp;
            } catch (\Throwable $e) {
                // ignore
            }
        }

        return 0;
    }

    public function render()
    {
        return view('livewire.pages.activity-log');
    }
}
