<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DocumentStatus;
use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\FormTemplate;
use Illuminate\Http\Request;

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

        $statusOptions = collect(DocumentStatus::cases())
            ->mapWithKeys(fn (DocumentStatus $status) => [$status->value => $status->label()])
            ->all();

        return view('admin.form-templates.index', compact('templates', 'statusOptions', 'documentTypes', 'registeredDocuments', 'importedReferenceCodes'));
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
            'downloadable_attachment' => ['required', 'file', 'max:20480'],
        ]);

        $attachmentPath = $request->file('downloadable_attachment')->storePublicly('form-templates', 'public');

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

    public function importFromDocument(Document $document)
    {
        $document->loadMissing(['draf.documentType', 'originatingOffice', 'draf.requestedBy']);

        $referenceCode = $document->draf?->reference_code;

        if (! filled($referenceCode)) {
            return back()->with('error', 'The selected registered document does not have a reference code.');
        }

        $attachmentPath = $document->downloadable_doc_path ?: $document->draf?->approved_attachment_path;
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
