@php
    // Pastikan JSON valid
    $buttonsArray = [];
    if (!empty($json[0])) {
        $raw = $json[0]; // data JSON

        $buttonsArray = is_string($raw) ? json_decode($raw, true) : $raw;
        if (!is_array($buttonsArray)) {
            $buttonsArray = [];
        }
    }

    $model = $json[1] ?? null; // model class
    $id = $json[2];
@endphp

@foreach ($buttonsArray as $item)
    @can($item['permission'] ?? '', $model)
        <a href="{{ route($item['url'], ['id_permohonan' => $id]) ?? '#' }}">
            <button class="btn btn-sm btn-{{ $item['color'] ?? 'primary' }}">
                @if (!empty($item['icon']))
                    <i class="{{ $item['icon'] }}"></i>
                @endif
                {{ $item['text'] ?? '' }}
            </button>
        </a>
    @endcan
@endforeach
