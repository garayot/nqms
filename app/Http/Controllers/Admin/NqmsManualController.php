<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DocumentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNqmsManualRequest;
use App\Http\Requests\UpdateNqmsManualRequest;
use App\Models\DocumentType;
use App\Models\FuncDiv;
use App\Models\NqmsManual;
use App\Models\Office;
use Illuminate\Http\Request;

class NqmsManualController extends Controller
{
    public function index(Request $request)
    {
        $manuals = NqmsManual::query()
            ->with('documentType')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($sub) use ($search) {
                    $sub->where('document_reference_code', 'like', "%{$search}%")
                        ->orWhere('doc_title', 'like', "%{$search}%")
                        ->orWhere('responsible', 'like', "%{$search}%")
                        ->orWhere('document_location', 'like', "%{$search}%");
                });
            })
            ->when($request->status, fn ($query, $status) => $query->where('status', $status))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $statusOptions = collect(DocumentStatus::cases())
            ->mapWithKeys(fn (DocumentStatus $status) => [$status->value => $status->label()])
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

        return view('admin.nqms-manuals.index', compact('manuals', 'statusOptions', 'documentTypes', 'functionalDivisions', 'offices'));
    }

    public function store(StoreNqmsManualRequest $request)
    {
        NqmsManual::create([
            ...$request->validated(),
            'created_by' => $request->user()->id,
        ]);

        return back()->with('success', 'NQMS manual document added.');
    }

    public function edit(NqmsManual $nqmsManual)
    {
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

        return view('admin.nqms-manuals.edit', compact('nqmsManual', 'documentTypes', 'functionalDivisions', 'offices'));
    }

    public function update(UpdateNqmsManualRequest $request, NqmsManual $nqmsManual)
    {
        $nqmsManual->update($request->validated());

        return redirect()->route('admin.nqms-manuals.index')->with('success', 'NQMS manual document updated.');
    }

    public function destroy(NqmsManual $nqmsManual)
    {
        $nqmsManual->delete();

        return back()->with('success', 'NQMS manual document deleted.');
    }
}
