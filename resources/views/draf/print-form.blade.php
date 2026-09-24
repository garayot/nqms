@php
    $requestForValue = $draf->request_for?->value ?? null;
    $applicabilityValue = $draf->applicability?->value ?? null;
    $reviewValue = $draf->review?->value ?? null;
    $approvalValue = $draf->approval?->value ?? null;
    $requesterName = $draf->requestedBy?->name ?? '___________________________';
    $reviewerName = $draf->reviewedBy?->name ?? '___________________________';
    $approverName = $draf->approvedBy?->name ?? '___________________________';

    $headerLogoPath = storage_path('app/public/logo/header.png');
    $footerLogoPath = storage_path('app/public/logo/footer.png');

    $headerLogo = file_exists($headerLogoPath)
        ? 'data:image/png;base64,' . base64_encode(file_get_contents($headerLogoPath))
        : null;

    $footerLogo = file_exists($footerLogoPath)
        ? 'data:image/png;base64,' . base64_encode(file_get_contents($footerLogoPath))
        : null;

@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>DRAF Form</title>
    <style>
        @font-face {
            font-family: 'Canterbury';
            src: url('/font/CanterburyRegular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @page {
            margin: 0;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #111827;
            margin: 0;
            padding: 0;
        }

        .page-wrapper {
            width: 100%;
            box-sizing: border-box;
        }


        .gov-header {
            text-align: center;
            padding: 8px 20px 0 20px;
        }

        .gov-header .top-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-bottom: 4px;
        }

        .gov-header img {
            width: 310px;
            height: 204px;
            margin-bottom: -10px;
        }

        .gov-title {
            font-family: 'Canterbury';
            font-size: 28px;
            color: #1f2937;
        }

        .gov-sub {
            margin-top: 2px;
            font-size: 10px;
            letter-spacing: 0.09em;
            text-transform: uppercase;
            font-weight: 700;
            color: #1f2937;
        }

        .header-divider {
            border: none;
            border-top: 1.5px solid #1e3a5f;
            margin: 3mm 0 2mm;
        }

        .footer-divider {
            border: 0;
            border-top: 1.5px solid #000;
            width: 96%;
            margin: 0 auto 8px auto;
        }

        .pdf-footer {
            width: 100%;
            background: #fff;
            padding: 8px 18px 0 18px;
            margin-top: 8px;
            box-sizing: border-box;
            page-break-inside: avoid;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-table td {
            border: none;
            padding: 0;
            vertical-align: middle;
        }

        .footer-logo-cell {
            width: 50px;
            padding-right: 10px;
        }

        .footer-logo-cell img {
            width: 90%;
            height: 82px;
            margin-top: -10px;
            margin-left: 5px;
            display: block;
        }

        .footer-meta-cell {
            vertical-align: top;
        }

        .meta-table {
            width: 100%;
            border-collapse: collapse;
            flex: left;
            font-size: 9px;
            table-layout: fixed;
        }

        .meta-table .meta-label {
            font-weight: 700;
            width: 28%;
        }

        .page {
            margin: 0;
            padding: 18px 14px 12px 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        td {
            border: 1px solid #374151;
            padding: 5px 6px;
            vertical-align: top;
            line-height: 1.35;
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        .section-label {
            font-weight: 700;
            background: #f3f4f6;
            text-transform: uppercase;
        }

        .label {
            font-weight: 600;
        }

        .checkbox {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 12px;
            height: 12px;
            border: 1.5px solid #111827;
            background: #ffffff;
            color: #111827;
            font-size: 10px;
            font-weight: 900;
            line-height: 1;
            text-align: center;
            margin-right: 6px;
            vertical-align: middle;
            padding: 0;
        }

        .inline {
            white-space: normal;
            display: inline-flex;
            align-items: flex-start;
            margin-right: 10px;
            max-width: 100%;
            vertical-align: top;
            gap: 4px;
        }

        .inline .checkbox {
            flex-shrink: 0;
        }

        .fill {
            min-height: 18px;
            display: block;
            word-wrap: break-word;
            overflow-wrap: anywhere;
        }

        .signature {
            font-weight: 600;
            text-align: center;
        }

        .small {
            font-size: 10px;
            color: #475569;
        }

        .text-area {
            min-height: 56px;
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
    
        <div class="gov-header">
            <div class="top-row">
                <img src="{{ $headerLogo }}" alt="DepEd Logo">
                
            </div>
        </div>
    

    <div class="page">
        <table>
            <tr>
                <td colspan="8" class="section-label">Section I - Request</td>
                <td colspan="6" class="section-label" style="text-align: right;">DRAF No. {{ $draf->draf_number ?: '________________' }}</td>
            </tr>
            <tr>
                <td colspan="4"><span class="label">Request for:</span></td>
                <td colspan="10">
                    <span class="inline"><span class="checkbox">{{ $requestForValue === 'creation' ? '✓' : '' }}</span>Creation</span>
                    <span class="inline"><span class="checkbox">{{ $requestForValue === 'revision' ? '✓' : '' }}</span>Revision</span>
                    <span class="inline"><span class="checkbox">{{ $requestForValue === 'disposition' ? '✓' : '' }}</span>Disposition/Deletion</span>
                </td>
            </tr>
            <tr>
                <td colspan="4"><span class="label">Document Type:</span></td>
                <td colspan="10">
                    @php
                        $docName = strtolower((string) ($draf->documentType?->name ?? ''));
                    @endphp
                    <div><span class="inline"><span class="checkbox">{{ str_contains($docName, 'form') || str_contains($docName, 'template') ? '✓' : '' }}</span>Form/Template</span></div>
                    <div><span class="inline"><span class="checkbox">{{ str_contains($docName, 'qms') ? '✓' : '' }}</span>QMS Manual</span></div>
                    <div><span class="inline"><span class="checkbox">{{ str_contains($docName, 'pawim') ? '✓' : '' }}</span>PAWIM</span></div>
                    <div><span class="inline"><span class="checkbox">{{ str_contains($docName, 'planning') || str_contains($docName, 'swot') || str_contains($docName, 'risk') || str_contains($docName, 'opcr') ? '✓' : '' }}</span>Planning Documents (SWOT, Risk Registry, Opportunity Registry, Relevant Interested Parties, OPCR)</span></div>
                    <div><span class="inline"><span class="checkbox">{{ str_contains($docName, 'operations') || str_contains($docName, 'manual') ? '✓' : '' }}</span>Operations Manual (Title Page, Introduction, Terms and Acronyms, Legal Bases, Forms/Templates)</span></div>
                    <div><span class="inline"><span class="checkbox">{{ str_contains($docName, 'quality') || str_contains($docName, 'control') ? '✓' : '' }}</span>Quality Control Plan</span></div>
                </td>
            </tr>
            <tr>
                <td colspan="4"><span class="label">Applicability:</span></td>
                <td colspan="10">
                    <span class="inline"><span class="checkbox">{{ $applicabilityValue === 'co' ? '✓' : '' }}</span>CO</span>
                    <span class="inline"><span class="checkbox">{{ $applicabilityValue === 'ro' ? '✓' : '' }}</span>RO</span>
                    <span class="inline"><span class="checkbox">{{ $applicabilityValue === 'sdo' ? '✓' : '' }}</span>SDO</span>
                    <span class="inline"><span class="checkbox">{{ $applicabilityValue === 'school' ? '✓' : '' }}</span>School</span>
                </td>
            </tr>
            <tr>
                <td colspan="4"><span class="label">Document Title:</span></td>
                <td colspan="10"><span class="fill">{{ $draf->title ?: '___________________________' }}</span></td>
            </tr>
            <tr>
                <td colspan="4"><span class="label">Document Reference Code:</span></td>
                <td colspan="3"><span class="fill">{{ $draf->reference_code ?: '________________' }}</span></td>
                <td colspan="6"><span class="label">Current Revision Number:</span></td>
                <td><span class="fill">{{ $draf->current_revision_no ?: '________________' }}</span></td>
            </tr>
            <tr>
                <td colspan="14" class="section-label">Reason for the request:</td>
            </tr>
            <tr>
                <td colspan="14" class="text-area">{{ $draf->reason ?: ' ' }}</td>
            </tr>
            <tr>
                <td colspan="2"><span class="label">Requested by:</span></td>
                <td colspan="6" class="signature">
                    <div class="fill">{{ $requesterName }}</div>
                    <div class="small">Signature over Printed Name and Position</div>
                </td>
                <td colspan="3"><span class="label">Date of Request:</span></td>
                <td colspan="3">{{ $draf->date_requested?->format('M d, Y') ?: '________________' }}</td>
            </tr>

            <tr>
                <td colspan="7" class="section-label">Section II – Review</td>
                <td colspan="7" class="section-label">Section III – Approval</td>
            </tr>
            <tr>
                <td colspan="3"><span class="inline"><span class="checkbox">{{ $reviewValue === 'recommend_approval' ? '✓' : '' }}</span>Recommend Approval</span></td>
                <td colspan="4"><span class="inline"><span class="checkbox">{{ $reviewValue === 'disapproved' ? '✓' : '' }}</span>Disapproved</span></td>
                <td colspan="5"><span class="inline"><span class="checkbox">{{ $approvalValue === 'approved' ? '✓' : '' }}</span>Approved</span></td>
                <td colspan="2"><span class="inline"><span class="checkbox">{{ $approvalValue === 'disapproved' ? '✓' : '' }}</span>Disapproved</span></td>
            </tr>
            <tr>
                <td colspan="7"><span class="label">Reason:</span><div class="fill">{{ $draf->reason1 ?: ' ' }}</div></td>
                <td colspan="7"><span class="label">Reason:</span><div class="fill">{{ $draf->reason2 ?: ' ' }}</div></td>
            </tr>
            <tr>
                <td style="width: 18%;"><span class="label">Reviewed by:</span></td>
                <td colspan="6" class="signature">
                    <div class="fill">{{ $reviewerName }}</div>
                    <div class="small">Signature over Printed Name and Position (Head of Committee)</div>
                </td>
                <td colspan="2"><span class="label">Approved by:</span></td>
                <td colspan="5" class="signature">
                    <div class="fill">{{ $approverName }}</div>
                    <div class="small">Signature over Printed Name and Position</div>
                </td>
            </tr>
            <tr>
                <td><span class="label">Date:</span></td>
                <td colspan="6">{{ $draf->reviewed_at?->format('M d, Y') ?: '________________' }}</td>
                <td colspan="2"><span class="label">Date:</span></td>
                <td colspan="5">{{ $draf->approved_at?->format('M d, Y') ?: '________________' }}</td>
            </tr>

            <tr>
                <td colspan="14" class="section-label">Section IV – Registration and Distribution</td>
            </tr>
            <tr>
                <td colspan="5"><span class="label">NEW REVISION NUMBER:</span></td>
                <td colspan="5"><span class="label">EFFECTIVITY DATE:</span></td>
                <td colspan="4"><span class="label">DATE REGISTERED IN DML:</span></td>
            </tr>
            <tr>
                <td colspan="5">{{ $draf->new_revision_number ?: '________________' }}</td>
                <td colspan="5">{{ $draf->effectivity_date?->format('M d, Y') ?: '________________' }}</td>
                <td colspan="4">{{ $draf->date_registered?->format('M d, Y') ?: '________________' }}</td>
            </tr>
            <tr>
                <td colspan="6"><span class="label">CONTROLLED COPY FILED BY:</span></td>
                <td colspan="8"><span class="label">COPY RECEIVED BY:</span></td>
            </tr>
            <tr>
                <td colspan="6" class="signature">
                    <div class="fill">_______________________________________</div>
                    <div class="small">Lead, Knowledge Management Team</div>
                </td>
                <td colspan="8" class="signature">
                    <div class="fill">_______________________________________</div>
                    <div class="small">Process Holder</div>
                </td>
            </tr>
            <tr>
                <td colspan="6"><span class="label">Date:</span></td>
                <td colspan="8"><span class="label">Date:</span></td>
            </tr>
        </table>
    </div>
    

    <div class="pdf-footer">
        <table class="footer-table">
            <tr>
                <td class="footer-logo-cell">
                    <img src="{{ $footerLogo }}" alt="DepEd Footer Logo">
                </td>
                
            </tr>
        </table>
    </div>

    </div>

</body>
</html>
