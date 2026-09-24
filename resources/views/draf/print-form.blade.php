@php
    $requestForValue = $draf->request_for?->value ?? null;
    $applicabilityValue = $draf->applicability?->value ?? null;
    $reviewValue = $draf->review?->value ?? null;
    $approvalValue = $draf->approval?->value ?? null;
    $requesterName = $draf->requestedBy?->name ?? '___________________________';
    $reviewerName = $draf->reviewedBy?->name ?? '___________________________';
    $approverName = $draf->approvedBy?->name ?? '___________________________';
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>DRAF Form</title>
    <style>
        @page {
            margin: 20mm 10mm 24mm 10mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #111827;
            margin: 0;
            padding: 0;
        }

        .pdf-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 18mm;
            padding: 4mm 10mm 0 10mm;
            border-bottom: 1px solid #cbd5e1;
            background: #f8fafc;
            font-size: 10px;
            letter-spacing: 0.08em;
            font-weight: 700;
            text-transform: uppercase;
            color: #0f172a;
        }

        .pdf-header .title {
            font-size: 15px;
            letter-spacing: 0.08em;
            margin-top: 2mm;
        }

        .pdf-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 16mm;
            padding: 2mm 10mm 0 10mm;
            border-top: 1px solid #cbd5e1;
            background: #f8fafc;
            font-size: 9px;
            color: #475569;
            text-align: center;
        }

        .page {
            margin-top: 24mm;
            margin-bottom: 18mm;
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
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 1px solid #111827;
            font-size: 10px;
            line-height: 10px;
            text-align: center;
            margin-right: 4px;
            vertical-align: middle;
        }

        .inline {
            white-space: nowrap;
        }

        .fill {
            min-height: 18px;
            display: block;
            word-wrap: break-word;
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

        .section-title {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="pdf-header">
        <div>Document Review and Approval Form (DRAF)</div>
        <div class="title">DRAF No. {{ $draf->draf_number ?: '________________' }}</div>
    </div>

    <div class="pdf-footer">
        Generated on {{ now()->format('F d, Y') }} · This document is for internal review and approval records only.
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
                    <span class="inline"><span class="checkbox">{{ $requestForValue === 'creation' ? '☑' : '☐' }}</span>Creation</span>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="inline"><span class="checkbox">{{ $requestForValue === 'revision' ? '☑' : '☐' }}</span>Revision</span>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="inline"><span class="checkbox">{{ $requestForValue === 'disposition' ? '☑' : '☐' }}</span>Disposition/Deletion</span>
                </td>
            </tr>
            <tr>
                <td colspan="4"><span class="label">Document Type:</span></td>
                <td colspan="10">
                    @php
                        $docTypes = $draf->documentType?->name ?? null;
                    @endphp
                    <div><span class="checkbox">{{ str_contains(strtolower((string) $docTypes), 'form') || str_contains(strtolower((string) $docTypes), 'template') ? '☑' : '☐' }}</span>Form/Template</div>
                    <div><span class="checkbox">{{ str_contains(strtolower((string) $docTypes), 'qms') ? '☑' : '☐' }}</span>QMS Manual</div>
                    <div><span class="checkbox">{{ str_contains(strtolower((string) $docTypes), 'pawim') ? '☑' : '☐' }}</span>PAWIM</div>
                    <div><span class="checkbox">{{ str_contains(strtolower((string) $docTypes), 'planning') || str_contains(strtolower((string) $docTypes), 'swot') || str_contains(strtolower((string) $docTypes), 'risk') || str_contains(strtolower((string) $docTypes), 'opcr') ? '☑' : '☐' }}</span>Planning Documents (SWOT, Risk Registry, Opportunity Registry, Relevant Interested Parties, OPCR)</div>
                    <div><span class="checkbox">{{ str_contains(strtolower((string) $docTypes), 'operations') || str_contains(strtolower((string) $docTypes), 'manual') ? '☑' : '☐' }}</span>Operations Manual (Title Page, Introduction, Terms and Acronyms, Legal Bases, Forms/Templates)</div>
                    <div><span class="checkbox">{{ str_contains(strtolower((string) $docTypes), 'quality') || str_contains(strtolower((string) $docTypes), 'control') ? '☑' : '☐' }}</span>Quality Control Plan</div>
                </td>
            </tr>
            <tr>
                <td colspan="4"><span class="label">Applicability:</span></td>
                <td colspan="10">
                    <span class="inline"><span class="checkbox">{{ $applicabilityValue === 'co' ? '☑' : '☐' }}</span>CO</span>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="inline"><span class="checkbox">{{ $applicabilityValue === 'ro' ? '☑' : '☐' }}</span>RO</span>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="inline"><span class="checkbox">{{ $applicabilityValue === 'sdo' ? '☑' : '☐' }}</span>SDO</span>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="inline"><span class="checkbox">{{ $applicabilityValue === 'school' ? '☑' : '☐' }}</span>School</span>
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
                <td colspan="3"><span class="checkbox">{{ $reviewValue === 'recommend_approval' ? '☑' : '☐' }}</span>Recommend Approval</td>
                <td colspan="4"><span class="checkbox">{{ $reviewValue === 'disapproved' ? '☑' : '☐' }}</span>Disapproved</td>
                <td colspan="5"><span class="checkbox">{{ $approvalValue === 'approved' ? '☑' : '☐' }}</span>Approved</td>
                <td colspan="2"><span class="checkbox">{{ $approvalValue === 'disapproved' ? '☑' : '☐' }}</span>Disapproved</td>
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
                    <div class="fill">Lead, Knowledge Management Team</div>
                    <div class="small">Lead, Knowledge Management Team</div>
                </td>
                <td colspan="8" class="signature">
                    <div class="fill">Process Holder</div>
                    <div class="small">Process Holder</div>
                </td>
            </tr>
            <tr>
                <td colspan="6"><span class="label">Date:</span></td>
                <td colspan="8"><span class="label">Date:</span></td>
            </tr>
        </table>
    </div>
</body>
</html>
