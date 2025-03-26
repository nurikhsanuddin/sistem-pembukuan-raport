<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $reportpdf->title }} - Print</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .toolbar {
            background-color: #f3f4f6;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .toolbar h1 {
            margin: 0;
            font-size: 1.25rem;
            color: #1f2937;
        }

        .button {
            background-color: #2563eb;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-left: 5px;
        }

        .button:hover {
            background-color: #1d4ed8;
        }

        .pdf-container {
            flex: 1;
            width: 100%;
            height: calc(100vh - 4rem);
            border: none;
        }

        @media print {
            .toolbar {
                display: none;
            }

            .pdf-container {
                height: 100vh;
            }
        }
    </style>
</head>

<body>
    <div class="toolbar">
        <h1>{{ $reportpdf->title }}</h1>
        <div>
            <button class="button" onclick="printDocument()">Print</button>
            <a href="{{ route('reportpdf.download', $reportpdf->id) }}" class="button"
                style="background-color: #059669;">Download</a>
            <a href="{{ route('reportpdf.index') }}" class="button" style="background-color: #6b7280;">Back</a>
        </div>
    </div>

    <iframe id="pdf-iframe" src="{{ route('reportpdf.view', $reportpdf->id) }}" class="pdf-container"></iframe>

    <script>
        function printDocument() {
            // Use iframe's print function for better PDF printing
            const iframe = document.getElementById('pdf-iframe');
            if (iframe.contentWindow) {
                iframe.contentWindow.focus();
                iframe.contentWindow.print();
            } else {
                // Fallback to window.print()
                window.print();
            }
        }

        // Only auto-trigger print when query param is present
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('autoprint') === 'true') {
                // Give the iframe a moment to fully load before showing print dialog
                setTimeout(printDocument, 1000);
            }
        };
    </script>
</body>

</html>
