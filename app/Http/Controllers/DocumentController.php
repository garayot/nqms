<?php

namespace App\Http\Controllers;

use App\Enums\DocumentStatus;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\FormTemplate;
use App\Models\FuncDiv;
use App\Models\NqmsManual;
use App\Models\Office;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function publicPrint(Request $request)
    {
        $documents = FormTemplate::query()
            ->with('documentType')
            ->where('status', $request->status ?: DocumentStatus::ACTIVE->value)
            ->when($request->document_type_id, function ($query, $documentTypeId) {
                $query->where('document_type_id', $documentTypeId);
            })
            ->when($request->originating_office, function ($query, $originatingOffice) {
                $query->where('responsible', $originatingOffice);
            })
            ->when($request->office, function ($query, $office) {
                $query->where('document_location', $office);
            })
            ->when($request->search, function ($query, $search) {
                $query->where(function ($sub) use ($search) {
                    $sub->where('document_reference_code', 'like', "%{$search}%")
                        ->orWhere('doc_title', 'like', "%{$search}%")
                        ->orWhere('responsible', 'like', "%{$search}%")
                        ->orWhere('document_location', 'like', "%{$search}%");
                });
            })
            ->orderBy('document_reference_code')
            ->get();

        $documentTypes = DocumentType::query()
            ->active()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('pages.forms-print', [
            'documents' => $documents,
            'documentTypes' => $documentTypes,
            'selectedDocumentTypeId' => $request->document_type_id,
            'selectedOriginatingOffice' => $request->originating_office,
        ]);
    }

    public function publicIndex(Request $request)
    {
        $documents = FormTemplate::query()
            ->with('documentType')
            ->where('status', $request->status ?: DocumentStatus::ACTIVE->value)
            ->when($request->document_type_id, function ($query, $documentTypeId) {
                $query->where('document_type_id', $documentTypeId);
            })
            ->when($request->originating_office, function ($query, $originatingOffice) {
                $query->where('responsible', $originatingOffice);
            })
            ->when($request->office, function ($query, $office) {
                $query->where('document_location', $office);
            })
            ->when($request->search, function ($query, $search) {
                $query->where(function ($sub) use ($search) {
                    $sub->where('document_reference_code', 'like', "%{$search}%")
                        ->orWhere('doc_title', 'like', "%{$search}%")
                        ->orWhere('responsible', 'like', "%{$search}%")
                        ->orWhere('document_location', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $statusOptions = collect(DocumentStatus::cases())
            ->mapWithKeys(fn (DocumentStatus $status) => [$status->value => $status->label()])
            ->all();

        $documentTypeOptions = DocumentType::query()
            ->orderBy('name')
            ->pluck('name', 'id')
            ->all();

        $originatingOfficeOptions = FuncDiv::query()
            ->orderBy('name')
            ->pluck('name', 'name')
            ->all();

        $officeOptions = Office::query()
            ->orderBy('name')
            ->pluck('name', 'name')
            ->all();

        return view('pages.forms-index', compact('documents', 'statusOptions', 'documentTypeOptions', 'originatingOfficeOptions', 'officeOptions'));
    }

    public function publicNqmsManualIndex(Request $request)
    {
        $documents = NqmsManual::query()
            ->with(['documentType', 'uploader'])
            ->where('status', $request->status ?: DocumentStatus::ACTIVE->value)
            ->when($request->document_type_id, function ($query, $documentTypeId) {
                $query->where('document_type_id', $documentTypeId);
            })
            ->when($request->originating_office, function ($query, $originatingOffice) {
                $query->where('responsible', $originatingOffice);
            })
            ->when($request->office, function ($query, $office) {
                $query->where('document_location', $office);
            })
            ->when($request->search, function ($query, $search) {
                $query->where(function ($sub) use ($search) {
                    $sub->where('document_reference_code', 'like', "%{$search}%")
                        ->orWhere('doc_title', 'like', "%{$search}%")
                        ->orWhere('responsible', 'like', "%{$search}%")
                        ->orWhere('document_location', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $statusOptions = collect(DocumentStatus::cases())
            ->mapWithKeys(fn (DocumentStatus $status) => [$status->value => $status->label()])
            ->all();

        $documentTypeOptions = DocumentType::query()
            ->orderBy('name')
            ->pluck('name', 'id')
            ->all();

        $originatingOfficeOptions = FuncDiv::query()
            ->orderBy('name')
            ->pluck('name', 'name')
            ->all();

        $officeOptions = Office::query()
            ->orderBy('name')
            ->pluck('name', 'name')
            ->all();

        return view('pages.nqms-manuals-index', compact('documents', 'statusOptions', 'documentTypeOptions', 'originatingOfficeOptions', 'officeOptions'));
    }

    public function index(Request $request)
    {
        $documents = Document::query()->with(['draf.documentType', 'originatingOffice'])
            ->when($request->search, function ($query, $search) {
                $query->whereHas('draf', function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('reference_code', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('documents.index', compact('documents'));
    }

    public function show(Document $document)
    {
        $document->load(['draf.documentType', 'originatingOffice']);

        return view('documents.show', compact('document'));
    }
}
