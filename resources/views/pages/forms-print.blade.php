@php
    $headerLogoPath = public_path('logo/header.png');
    $footerLogoPath = public_path('logo/footer.png');

    $headerLogo = file_exists($headerLogoPath)
        ? 'data:image/png;base64,' . base64_encode(file_get_contents($headerLogoPath))
        : null;

    $footerLogo = file_exists($footerLogoPath)
        ? 'data:image/png;base64,' . base64_encode(file_get_contents($footerLogoPath))
        : null;

    $selectedDocumentTypeLabel = blank($selectedDocumentTypeId)
        ? 'All Document Types'
        : ($documentTypes->firstWhere('id', (int) $selectedDocumentTypeId)?->name ?? 'All Document Types');

    $selectedStatusLabel = filled(request('status'))
        ? (\App\Enums\DocumentStatus::tryFrom((string) request('status'))?->label() ?? ucfirst((string) request('status')))
        : 'All Statuses';

    $selectedLocationLabel = request('office') ?: 'All Locations';
    $selectedOriginatingOfficeLabel = $selectedOriginatingOffice ?: 'All Originating Offices';
    $searchLabel = request('search') ?: 'None';

    $documents = $documents->values();
    $firstPageRows = 10;
    $continuationPageRows = 14;
    $pages = [];

    if ($documents->isEmpty()) {
        $pages[] = collect();
    } else {
        $pages[] = $documents->slice(0, $firstPageRows)->values();
        $remaining = $documents->slice($firstPageRows)->values();

        while ($remaining->isNotEmpty()) {
            $pages[] = $remaining->slice(0, $continuationPageRows)->values();
            $remaining = $remaining->slice($continuationPageRows)->values();
        }
    }

    $totalPages = count($pages);
@endphp

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Forms and Templates - Print Preview</title>
        <style>
            @page {
                size: A4 landscape;
                margin: 0;
            }

            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                background: #e2e8f0;
                color: #0f172a;
                font-family: Arial, sans-serif;
                font-size: 11px;
                line-height: 1.35;
            }

            .preview-toolbar {
                position: sticky;
                top: 0;
                z-index: 20;
                display: flex;
                justify-content: flex-end;
                gap: 12px;
                padding: 16px 24px;
                background: rgba(226, 232, 240, 0.95);
                backdrop-filter: blur(6px);
            }

            .preview-button {
                border: 1px solid #cbd5e1;
                border-radius: 8px;
                background: #fff;
                color: #0f172a;
                cursor: pointer;
                font-size: 13px;
                font-weight: 700;
                padding: 10px 16px;
                text-decoration: none;
            }

            .preview-button.primary {
                background: #0f3d68;
                border-color: #0f3d68;
                color: #fff;
            }

            .document-preview {
                padding: 0 0 32px;
            }

            .page {
                width: 297mm;
                min-height: 210mm;
                margin: 0 auto 16px;
                padding: 8mm 10mm 8mm;
                background: #fff;
                box-shadow: 0 10px 30px rgba(15, 23, 42, 0.12);
                display: flex;
                flex-direction: column;
                page-break-after: always;
            }

            .page:last-child {
                page-break-after: auto;
            }

            .header-image {
                width: 40%;
                margin-left: auto;
                margin-right: auto;
                margin-bottom: 6mm;
            }

            .header-image img,
            .footer-image img {
                width: 70%;
                display: block;
                margin: 0 auto;
            }

            .page-title {
                margin: 0 0 5mm;
                text-align: center;
            }

            .page-title h1 {
                margin: 0;
                font-size: 20px;
                font-weight: 700;
                letter-spacing: 0.04em;
                text-transform: uppercase;
            }

            .page-title p {
                margin: 6px 0 0;
                font-size: 11px;
                color: #475569;
            }

            .summary-table,
            .list-table {
                width: 100%;
                border-collapse: collapse;
                table-layout: fixed;
            }

            .summary-table {
                margin-bottom: 5mm;
            }

            .summary-table th,
            .summary-table td,
            .list-table th,
            .list-table td {
                border: 1px solid #334155;
                padding: 6px 7px;
                vertical-align: top;
            }

            .summary-table th,
            .list-table th {
                background: #dbeafe;
                font-weight: 700;
                text-align: center;
            }

            .summary-table th {
                width: 20%;
                text-align: left;
            }

            .list-table th:nth-child(1) {
                width: 13%;
            }

            .list-table th:nth-child(2) {
                width: 25%;
            }

            .list-table th:nth-child(3) {
                width: 14%;
            }

            .list-table th:nth-child(4) {
                width: 11%;
            }

            .list-table th:nth-child(5) {
                width: 10%;
            }

            .list-table th:nth-child(6) {
                width: 11%;
            }

            .list-table th:nth-child(7) {
                width: 8%;
            }

            .list-table th:nth-child(8) {
                width: 8%;
            }

            .text-center {
                text-align: center;
            }

            .nowrap {
                white-space: nowrap;
            }

            .empty-state {
                text-align: center;
                color: #64748b;
                padding: 18px 0;
            }

            .page-spacer {
                flex: 1 1 auto;
            }

            .footer-wrap {
                margin-top: 6mm;
            }

            .page-meta {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 3mm;
                font-size: 10px;
                color: #475569;
            }

            .footer-image {
                width: 100%;
            }

            @media print {
                body {
                    background: #fff;
                }

                .preview-toolbar {
                    display: none;
                }

                .document-preview {
                    padding: 0;
                }

                .page {
                    margin: 0;
                    box-shadow: none;
                }
            }
        </style>
    </head>
    <body>
        <div class="preview-toolbar">
            <a href="{{ route('forms.index', request()->query()) }}" class="preview-button">Back to list</a>
            <button type="button" class="preview-button primary" onclick="window.print()">Print</button>
        </div>

        <div class="document-preview">
            @foreach ($pages as $pageIndex => $pageDocuments)
                <section class="page">
                    @if ($pageIndex === 0 && $headerLogo)
                        <div class="header-image">
                            <img src="{{ $headerLogo }}" alt="Print header">
                        </div>
                    @endif

                    @if ($pageIndex === 0)
                        <div class="page-title">
                            <h1>Document Master List</h1>
                        </div>

                        <table class="summary-table">
                            <tbody>
                                <tr>
                                    <th>Originating Office</th>
                                    <td>{{ $selectedOriginatingOfficeLabel }}</td>
                                    <th>Document Type</th>
                                    <td>{{ $selectedDocumentTypeLabel }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ $selectedStatusLabel }}</td>
                                    <th>Location</th>
                                    <td>{{ $selectedLocationLabel }}</td>
                                </tr>
                                <tr>
                                    <th>Search Filter</th>
                                    <td colspan="3">{{ $searchLabel }}</td>
                                </tr>
                            </tbody>
                        </table>
                    @endif

                    <table class="list-table">
                        <thead>
                            <tr>
                                <th>Document Reference Code</th>
                                <th>Document Title/Description</th>
                                <th>Originating Office</th>
                                <th>Person Responsible</th>
                                <th>Revision Number</th>
                                <th>Effectivity Date</th>
                                <th>Location of Controlled Document</th>
                                <th>Document Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pageDocuments as $document)
                                <tr>
                                    <td>{{ $document->document_reference_code }}</td>
                                    <td>{{ $document->doc_title }}</td>
                                    <td>{{ $document->responsible ?: 'N/A' }}</td>
                                    <td>{{ $document->uploader?->name ?? 'N/A' }}</td>
                                    <td class="text-center">{{ $document->revision_number ?: 'N/A' }}</td>
                                    <td class="nowrap">{{ $document->effectivity_date?->format('M d, Y') ?: 'N/A' }}</td>
                                    <td>{{ $document->document_location ?: 'N/A' }}</td>
                                    <td class="text-center">{{ $document->status?->label() ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="empty-state">No records found for the selected filters.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="page-spacer"></div>

                    <div class="footer-wrap">
                        <div class="page-meta">
                            <div>Generated: {{ now()->format('M d, Y h:i A') }}</div>
                            <div>Page {{ $pageIndex + 1 }} of {{ $totalPages }}</div>
                        </div>

                        @if ($footerLogo)
                            <div class="footer-image">
                                <img src="{{ $footerLogo }}" alt="Print footer">
                            </div>
                        @endif
                    </div>
                </section>
            @endforeach
        </div>
    </body>
</html>
