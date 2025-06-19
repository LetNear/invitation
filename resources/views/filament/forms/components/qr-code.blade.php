@php
    $record = $getRecord();
    $code = $record?->code;
    $url = $code ? url('/invite/' . $code) : null;
@endphp

@if ($url)
    <div class="mt-2">
        {!! QrCode::size(150)->generate($url) !!}
        <p class="text-xs text-gray-500 mt-2">Invitation URL: <br>{{ $url }}</p>
    </div>
@else
    <p class="text-sm text-gray-400">QR code will appear once the invite is saved and code is generated.</p>
@endif
