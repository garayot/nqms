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
    public function isoPortal(Request $request)
    {
        $search = $request->string('search')->value();
        $folder = strtolower($request->string('folder')->value());
        $division = $request->string('division')->value();
        $office = $request->string('office')->value();

        $divisionFolders = collect(['OSDS', 'CID', 'SGOD']);

        $portalQuery = FormTemplate::query()
            ->with(['documentType', 'uploader'])
            ->where('status', DocumentStatus::ACTIVE->value)
            ->when(filled($division), fn ($query) => $query->where('responsible', $division))
            ->when(filled($office), fn ($query) => $query->where('document_location', $office))
            ->when(filled($search), function ($query) use ($search): void {
                $query->where(function ($sub) use ($search): void {
                    $sub->where('document_reference_code', 'like', "%{$search}%")
                        ->orWhere('doc_title', 'like', "%{$search}%")
                        ->orWhere('responsible', 'like', "%{$search}%")
                        ->orWhere('document_location', 'like', "%{$search}%")
                        ->orWhereHas('uploader', function ($uploaderQuery) use ($search): void {
                            $uploaderQuery->where('name', 'like', "%{$search}%");
                        });
                });
            });

        $documents = (clone $portalQuery)
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $availableDivisions = FuncDiv::query()
            ->whereIn('name', $divisionFolders->all())
            ->orderByRaw("FIELD(name, 'OSDS', 'CID', 'SGOD')")
            ->pluck('name')
            ->values();

        if ($availableDivisions->isEmpty()) {
            $availableDivisions = FuncDiv::query()
                ->orderBy('name')
                ->pluck('name')
                ->values();
        }

        $officeFolders = filled($division)
            ? (clone $portalQuery)
                ->whereNotNull('document_location')
                ->distinct()
                ->orderBy('document_location')
                ->pluck('document_location')
                ->values()
            : collect();

        $divisionCounts = (clone FormTemplate::query())
            ->where('status', DocumentStatus::ACTIVE->value)
            ->selectRaw('responsible, COUNT(*) as total')
            ->groupBy('responsible')
            ->pluck('total', 'responsible');

        $officeCounts = filled($division)
            ? (clone FormTemplate::query())
                ->where('status', DocumentStatus::ACTIVE->value)
                ->where('responsible', $division)
                ->selectRaw('document_location, COUNT(*) as total')
                ->groupBy('document_location')
                ->pluck('total', 'document_location')
            : collect();

        return view('pages.iso-portal-index', compact(
            'availableDivisions',
            'divisionCounts',
            'division',
            'documents',
            'folder',
            'office',
            'officeCounts',
            'officeFolders',
            'search',
        ));
    }

    public function publicPrint(Request $request)
    {
        $documents = FormTemplate::query()
            ->with(['documentType', 'uploader'])
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->string('status')->value());
            })
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
                        ->orWhere('document_location', 'like', "%{$search}%")
                        ->orWhereHas('uploader', function ($uploaderQuery) use ($search) {
                            $uploaderQuery->where('name', 'like', "%{$search}%");
                        });
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
            ->with(['documentType', 'uploader'])
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->string('status')->value());
            })
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
                        ->orWhere('document_location', 'like', "%{$search}%")
                        ->orWhereHas('uploader', function ($uploaderQuery) use ($search) {
                            $uploaderQuery->where('name', 'like', "%{$search}%");
                        });
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
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->string('status')->value());
            })
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
