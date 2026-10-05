<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DocumentStatus;
use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\FormTemplate;
use App\Models\FuncDiv;
use App\Models\Office;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FormTemplateController extends Controller
{
    public function index(Request $request)
    {
        $templates = FormTemplate::query()
            ->with('documentType')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($sub) use ($search) {
                    $sub->where('document_reference_code', 'like', "%{$search}%")
                        ->orWhere('doc_title', 'like', "%{$search}%")
                        ->orWhere('responsible', 'like', "%{$search}%")
                        ->orWhere('document_location', 'like', "%{$search}%")
                        ->orWhereHas('documentType', function ($typeQuery) use ($search) {
                            $typeQuery->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->status, fn ($query, $status) => $query->where('status', $status))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $registeredDocuments = Document::query()
            ->with(['draf.documentType', 'originatingOffice'])
            ->latest()
            ->paginate(8, ['*'], 'registered_documents')
            ->withQueryString();

        $importedReferenceCodes = FormTemplate::query()
            ->pluck('document_reference_code')
            ->filter()
            ->all();

        $documentTypes = DocumentType::query()
            ->active()
            ->orderBy('name')
            ->get(['id', 'name']);

        $functionalDivisions = FuncDiv::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        $offices = Office::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        $statusOptions = collect(DocumentStatus::cases())
            ->mapWithKeys(fn (DocumentStatus $status) => [$status->value => $status->label()])
            ->all();

        return view('admin.form-templates.index', compact('templates', 'statusOptions', 'documentTypes', 'registeredDocuments', 'importedReferenceCodes', 'functionalDivisions', 'offices'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'document_type_id' => ['required', 'exists:document_types,id'],
            'document_reference_code' => ['required', 'string', 'max:255', 'unique:form_templates,document_reference_code'],
            'doc_title' => ['required', 'string', 'max:255'],
            'responsible' => ['required', 'string', 'max:255'],
            'revision_number' => ['nullable', 'string', 'max:255'],
            'effectivity_date' => ['nullable', 'date'],
            'document_location' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:active,obsolete'],
            'downloadable_attachment_url' => ['nullable', 'url', 'max:2048'],
        ]);

        $attachmentPath = filled($validated['downloadable_attachment_url'] ?? null)
            ? $validated['downloadable_attachment_url']
            : null;

        FormTemplate::create([
            'document_type_id' => $validated['document_type_id'],
            'document_reference_code' => $validated['document_reference_code'],
            'doc_title' => $validated['doc_title'],
            'responsible' => $validated['responsible'],
            'revision_number' => $validated['revision_number'] ?? null,
            'effectivity_date' => $validated['effectivity_date'] ?? null,
            'document_location' => $validated['document_location'] ?? null,
            'status' => $validated['status'],
            'downloadable_attachment_path' => $attachmentPath,
        ]);

        return back()->with('success', 'Form/template added.');
    }

    public function downloadCsvTemplate()
    {
        $headers = [
            'document_type',
            'document_reference_code',
            'doc_title',
            'responsible',
            'revision_number',
            'effectivity_date',
            'document_location',
            'status',
            'downloadable_attachment_url',
        ];

        $sampleRow = [
            'Form/Template',
            'SDO-OSDS-F001',
            'Sample Form Title',
            'Planning Division',
            '01',
            '2026-09-25',
            'Main Office',
            'active',
            'https://example.com/sample-form.pdf',
        ];

        return response()->streamDownload(function () use ($headers, $sampleRow): void {
            $output = fopen('php://output', 'w');

            if (! $output) {
                return;
            }

            fputcsv($output, $headers);
            fputcsv($output, $sampleRow);

            fclose($output);
        }, 'form-templates-import-template.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function importCsv(Request $request)
    {
        $validated = $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt', 'max:20480'],
        ]);

        $filePath = $validated['csv_file']->getRealPath();
        $handle = fopen($filePath, 'r');

        if (! $handle) {
            return back()->with('error', 'Unable to read the uploaded CSV file.');
        }

        $rawHeaders = fgetcsv($handle);

        if (! $rawHeaders) {
            fclose($handle);

            return back()->with('error', 'The uploaded CSV file is empty.');
        }

        $headers = array_map(function ($header): string {
            return Str::of((string) $header)
                ->lower()
                ->replace([' ', '-', '/'], '_')
                ->replace('__', '_')
                ->trim()
                ->value();
        }, $rawHeaders);

        $imported = 0;
        $skipped = 0;

        while (($row = fgetcsv($handle)) !== false) {
            if (count(array_filter($row, fn ($value) => filled($value))) === 0) {
                continue;
            }

            $rowData = array_combine($headers, array_pad($row, count($headers), null));

            if ($rowData === false) {
                $skipped++;

                continue;
            }

            $referenceCode = trim((string) ($rowData['document_reference_code'] ?? $rowData['reference_code'] ?? ''));
            $docTitle = trim((string) ($rowData['doc_title'] ?? $rowData['title'] ?? ''));
            $responsible = trim((string) ($rowData['originating_office'] ?? $rowData['responsible'] ?? ''));

            if ($referenceCode === '' || $docTitle === '' || $responsible === '') {
                $skipped++;

                continue;
            }

            $documentTypeId = null;
            $documentTypeIdValue = $rowData['document_type_id'] ?? null;

            if (is_numeric($documentTypeIdValue)) {
                $documentTypeId = DocumentType::query()
                    ->active()
                    ->whereKey((int) $documentTypeIdValue)
                    ->value('id');
            }

            if (! $documentTypeId) {
                $documentTypeName = trim((string) ($rowData['document_type'] ?? $rowData['doc_type'] ?? ''));

                if ($documentTypeName !== '') {
                    $documentTypeId = DocumentType::query()
                        ->active()
                        ->where('name', $documentTypeName)
                        ->value('id');
                }
            }

            if (! $documentTypeId) {
                $skipped++;

                continue;
            }

            $status = strtolower(trim((string) ($rowData['status'] ?? DocumentStatus::ACTIVE->value)));

            if (! in_array($status, [DocumentStatus::ACTIVE->value, DocumentStatus::OBSOLETE->value], true)) {
                $status = DocumentStatus::ACTIVE->value;
            }

            $effectivityDate = null;
            $effectivityDateRaw = trim((string) ($rowData['effectivity_date'] ?? ''));

            if ($effectivityDateRaw !== '') {
                try {
                    $effectivityDate = Carbon::parse($effectivityDateRaw)->toDateString();
                } catch (\Throwable) {
                    $effectivityDate = null;
                }
            }

            $attachment = trim((string) (
                $rowData['downloadable_attachment_url']
                ?? $rowData['downloadable_attachment']
                ?? $rowData['attachment_url']
                ?? ''
            ));

            FormTemplate::updateOrCreate(
                ['document_reference_code' => $referenceCode],
                [
                    'document_type_id' => $documentTypeId,
                    'doc_title' => $docTitle,
                    'responsible' => $responsible,
                    'revision_number' => trim((string) ($rowData['revision_number'] ?? '')) ?: null,
                    'effectivity_date' => $effectivityDate,
                    'document_location' => trim((string) ($rowData['document_location'] ?? '')) ?: null,
                    'status' => $status,
                    'downloadable_attachment_path' => $attachment !== '' ? $attachment : null,
                ]
            );

            $imported++;
        }

        fclose($handle);

        $message = "CSV import completed: {$imported} imported";

        if ($skipped > 0) {
            $message .= ", {$skipped} skipped";
        }

        return back()->with('success', $message.'.');
    }

    public function importFromDocument(Document $document)
    {
        $document->loadMissing(['draf.documentType', 'originatingOffice', 'draf.requestedBy']);

        $referenceCode = $document->draf?->reference_code;

        if (! filled($referenceCode)) {
            return back()->with('error', 'The selected registered document does not have a reference code.');
        }

        $attachmentPath = $document->downloadable_doc_path ?: $document->draf?->approved_attachment_url;
        $responsible = $document->originatingOffice?->office
            ?? $document->draf?->requestedBy?->office
            ?? $document->draf?->requestedBy?->name
            ?? 'N/A';

        FormTemplate::updateOrCreate(
            ['document_reference_code' => $referenceCode],
            [
                'document_type_id' => $document->draf?->doc_type_id,
                'doc_title' => $document->draf?->title ?? $referenceCode,
                'responsible' => $responsible,
                'revision_number' => $document->draf?->new_revision_number
                    ?? $document->draf?->current_revision_no,
                'effectivity_date' => $document->draf?->effectivity_date
                    ?? $document->draf?->date_requested,
                'document_location' => $document->location ?? 'Repository',
                'status' => $document->status?->value ?? DocumentStatus::ACTIVE->value,
                'downloadable_attachment_path' => $attachmentPath,
            ]
        );

        return back()->with('success', 'Registered document added to forms/templates.');
    }
}
