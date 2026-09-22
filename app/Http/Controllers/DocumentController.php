<?php

namespace App\Http\Controllers;

use App\Enums\DocumentStatus;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function publicIndex(Request $request)
    {
        $documents = Document::query()
            ->with(['draf.documentType', 'originatingOffice'])
            ->where('status', DocumentStatus::ACTIVE->value)
            ->when($request->search, function ($query, $search) {
                $query->whereHas('draf', function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('reference_code', 'like', "%{$search}%");
                });
            })
            ->when($request->document_type, function ($query, $value) {
                $query->whereHas('draf', function ($q) use ($value) {
                    $q->where('doc_type_id', $value);
                });
            })
            ->when($request->source, function ($query, $value) {
                $query->whereHas('draf', function ($q) use ($value) {
                    $q->where('source', $value);
                });
            })
            ->when($request->applicability, function ($query, $value) {
                $query->whereHas('draf', function ($q) use ($value) {
                    $q->where('applicability', $value);
                });
            })
            ->when($request->status, function ($query, $value) {
                $query->where('status', $value);
            })
            ->when($request->originating_office, function ($query, $value) {
                $query->where('originating_office_id', $value);
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('pages.forms-index', compact('documents'));
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
