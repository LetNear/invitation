@php
    $record = $getRecord();
    $code = $record?->code;
    $url = $code ? url('/invite/' . $code) : null;

    // Define template and display size
    $templateSize = 800; // To match the template's size
$displaySize = 400; // Adjust for screen display

// Generate the QR code SVG
$qrSvgRaw = $url ? QrCode::size(322)->generate($url) : ''; // Size to fit within placeholder

if ($qrSvgRaw) {
    $templateImagePath = public_path('images/template.png');
    $templateDataUri = '';

    if (file_exists($templateImagePath)) {
        $templateData = base64_encode(file_get_contents($templateImagePath));
        $mimeType = mime_content_type($templateImagePath);
        $templateDataUri = "data:$mimeType;base64,$templateData";
    }

    // Fine-tuning placement
    $x = 239; // Keep as it is
    $y = 260; // Adjust upwards for better fit

    // Add guest name
    $guestName = $record->guest->name ?? 'Guest';
    $guestAffiliation = $record->guest->affiliation ?? '';
    $fontSize = 20;
    $textYPosition = $y + 360; // Position below the QR code

    // Combine template and QR, including guest name
    $qrSvg =
        '<svg xmlns="http://www.w3.org/2000/svg" width="' .
        $templateSize .
        '" height="' .
        $templateSize .
        '">
                    <image href="' .
        $templateDataUri .
        '" x="0" y="0" height="' .
        $templateSize .
        '" width="' .
        $templateSize .
        '" />
                    <g transform="translate(' .
        $x .
        ',' .
        $y .
        ')">' .
        $qrSvgRaw .
        '</g>
                    <text x="' .
        $templateSize / 2 .
        '" y="' .
        $textYPosition .
        '" font-size="' .
        $fontSize .
        '" text-anchor="middle" fill="black">' .
        $guestAffiliation .
        ' ' .
        $guestName .
        '</text>
                </svg>';
    }
@endphp

@if ($url)
    <div id="qrCodeContainer" style="text-align: center; margin-top: 1rem;">
        <div style="width: {{ $displaySize }}px; height: {{ $displaySize }}px; margin: auto; overflow: visible;">
            <div style="transform: scale({{ $displaySize / $templateSize }}); transform-origin: top left;">
                {!! $qrSvg !!}
            </div>
        </div>
    </div>

    <p class="text-sm text-gray-700 font-semibold mt-2">{{ $record->guest->name ?? 'Guest' }}</p>

    <p class="text-xs text-blue-600 cursor-pointer hover:underline" onclick="copyToClipboard('{{ $url }}')">
        Invitation URL:<br>{{ $url }}
    </p>
    <span id="copy-feedback" class="text-green-600 text-xs" style="display:none;">Link copied!</span>

    <button id="downloadButton" class="mt-2 px-4 py-1 text-sm text-black bg-blue-500 hover:bg-blue-600 rounded">
        Download QR Code
    </button>
@else
    <p class="text-sm text-gray-400">QR code will appear once the invite is saved and code is generated.</p>
@endif

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            const feedback = document.getElementById('copy-feedback');
            feedback.style.display = 'inline';
            setTimeout(() => feedback.style.display = 'none', 2000);
        });
    }

    function downloadPNGQRCode() {
        const svgElement = document.querySelector('#qrCodeContainer svg');
        if (!svgElement) {
            alert('QR code not found for download.');
            return;
        }

        const svgData = new XMLSerializer().serializeToString(svgElement);
        const img = new Image();
        const svgBlob = new Blob([svgData], {
            type: 'image/svg+xml;charset=utf-8'
        });
        const url = URL.createObjectURL(svgBlob);

        img.onload = function() {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');

            const svgWidth = img.width;
            const svgHeight = img.height;

            canvas.width = svgWidth;
            canvas.height = svgHeight;

            ctx.drawImage(img, 0, 0, svgWidth, svgHeight);

            canvas.toBlob(function(blob) {
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'qr-code.png';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            }, 'image/png');

            URL.revokeObjectURL(this.src);
        };

        img.src = url;
    }

    document.getElementById('downloadButton').onclick = downloadPNGQRCode;
</script>
