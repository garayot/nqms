<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Forms and Templates - Print</title>
        <style>
            @page {
                size: A4 landscape;
                margin: 12mm;
            }

            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                color: #0f172a;
                font-family: Arial, sans-serif;
                font-size: 11px;
                line-height: 1.3;
            }

            .print-wrap {
                width: 100%;
            }

            .header {
                border-bottom: 2px solid #334155;
                padding-bottom: 8px;
                margin-bottom: 8px;
                text-align: center;
            }

            .header h1 {
                margin: 0;
                font-size: 18px;
                font-weight: 700;
                letter-spacing: 0.2px;
            }

            .header p {
                margin: 2px 0 0;
                font-size: 12px;
            }

            .meta-table,
            .list-table {
                width: 100%;
                border-collapse: collapse;
            }

            .meta-table td,
            .meta-table th,
            .list-table td,
            .list-table th {
                border: 1px solid #475569;
                padding: 4px 6px;
                vertical-align: top;
            }

            .meta-table th,
            .list-table th {
                background: #dbeafe;
                font-weight: 700;
                text-align: center;
            }

            .checkbox-grid {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 4px 10px;
            }

            .checkbox-item {
                white-space: nowrap;
            }

            .checkbox {
                display: inline-block;
                width: 10px;
                height: 10px;
                margin-right: 4px;
                border: 1px solid #334155;
                vertical-align: middle;
                text-align: center;
                line-height: 8px;
                font-size: 9px;
            }

            .footer {
                margin-top: 10px;
                border-top: 1px solid #64748b;
                padding-top: 6px;
                font-size: 10px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .text-center {
                text-align: center;
            }

            .nowrap {
                white-space: nowrap;
            }
        </style>
    </head>
    <body>
        <div class="print-wrap">
            <div class="header">
                <h1>Department of Education</h1>
                <p>Quality Management System (QMS) - Forms and Templates Master List</p>
            </div>

            <table class="meta-table">
                <tr>
                    <th style="width: 18%;">Bureau/Service/Functional Division/School</th>
                    <td>{{ $selectedOriginatingOffice ?: 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Document Type</th>
                    <td>
                        <div class="checkbox-grid">
                            @foreach ($documentTypes as $documentType)
                                @php
                                    $isChecked = blank($selectedDocumentTypeId)
                                        || (string) $selectedDocumentTypeId === (string) $documentType->id;
                                @endphp
                                <div class="checkbox-item">
                                    <span class="checkbox">{{ $isChecked ? '✓' : '' }}</span>{{ $documentType->name }}
                                </div>
                            @endforeach
                        </div>
                    </td>
                </tr>
            </table>

            <table class="list-table" style="margin-top: 8px;">
                <thead>
                    <tr>
                        <th style="width: 13%;">Document Reference Code</th>
                        <th style="width: 28%;">Document Title/Description</th>
                        <th style="width: 14%;">Originating Office</th>
                        <th style="width: 10%;">Revision Number</th>
                        <th style="width: 12%;">Effectivity Date</th>
                        <th style="width: 15%;">Location of Controlled Document</th>
                        <th style="width: 8%;">Document Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($documents as $document)
                        <tr>
                            <td>{{ $document->document_reference_code }}</td>
                            <td>{{ $document->doc_title }}</td>
                            <td>{{ $document->responsible ?: 'N/A' }}</td>
                            <td class="text-center">{{ $document->revision_number ?: 'N/A' }}</td>
                            <td class="nowrap">{{ $document->effectivity_date?->format('M d, Y') ?: 'N/A' }}</td>
                            <td>{{ $document->document_location ?: 'N/A' }}</td>
                            <td class="text-center">{{ $document->status?->value === 'active' ? 'A' : 'O' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No records found for the selected filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="footer">
                <div>Generated: {{ now()->format('M d, Y h:i A') }}</div>
                <div>Page 1</div>
            </div>
        </div>

        <script>
            window.addEventListener('load', () => {
                window.print();
            });
        </script>
    </body>
</html>
