<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentType;
use Illuminate\Http\Request;

class DocumentTypeController extends Controller
{
    public function index(Request $request)
    {
        $types = DocumentType::query()
            ->when($request->search, fn ($q, $search) => $q->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.document-types.index', compact('types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:document_types,name'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        DocumentType::create($validated);

        return back()->with('success', 'Document type created.');
    }

    public function update(Request $request, DocumentType $documentType)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:document_types,name,'.$documentType->id],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        $documentType->update($validated);

        return back()->with('success', 'Document type updated.');
    }
}
