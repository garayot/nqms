<?php

namespace App\Http\Controllers;

use App\Enums\DocumentStatus;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\FormTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class DocumentController extends Controller
{
    public function publicIndex(Request $request)
    {
        $documents = FormTemplate::query()
            ->with('documentType')
            ->where('status', $request->status ?: DocumentStatus::ACTIVE->value)
            ->when($request->document_type_id, function ($query, $documentTypeId) {
                $query->where('document_type_id', $documentTypeId);
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

        return view('pages.forms-index', compact('documents', 'statusOptions', 'documentTypeOptions'));
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

    public function download(Document $document): BinaryFileResponse
    {
        $path = $document->downloadable_doc_path;

        if (! filled($path)) {
            abort(404);
        }

        if (Storage::disk('local')->exists($path)) {
            return response()->download(Storage::disk('local')->path($path));
        }

        if (Storage::disk('public')->exists($path)) {
            return response()->download(Storage::disk('public')->path($path));
        }

        abort(404);
    }

    public function downloadFormTemplate(FormTemplate $formTemplate): Response
    {
        $path = $formTemplate->downloadable_attachment_path;

        if (! filled($path)) {
            abort(404);
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return redirect()->away($path);
        }

        if (Storage::disk('public')->exists($path)) {
            return response()->download(Storage::disk('public')->path($path));
        }

        if (Storage::disk('local')->exists($path)) {
            return response()->download(Storage::disk('local')->path($path));
        }

        abort(404);
    }
}
