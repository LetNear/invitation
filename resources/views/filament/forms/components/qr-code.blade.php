@php
    $record = $getRecord();
    $code = $record?->code;
@endphp

@if ($code)
    <div class="mt-2">
        {!! QrCode::size(100)->generate($code) !!}
        <p class="text-xs text-gray-500 mt-2">QR for: {{ $code }}</p>
    </div>
@else
    <p class="text-sm text-gray-400">QR will appear once the record is saved.</p>
@endif
