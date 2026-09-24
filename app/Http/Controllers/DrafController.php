<?php

namespace App\Http\Controllers;

use App\Enums\DrafStatus;
use App\Http\Requests\StoreDrafRequest;
use App\Http\Requests\UpdateDrafRequest;
use App\Models\DocumentType;
use App\Models\Draf;
use App\Models\DrafHistory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DrafController extends Controller
{
    public function index()
    {
        $drafs = Draf::with(['documentType', 'requestedBy'])
            ->where('requested_by', Auth::id())
            ->latest()
            ->paginate(10);

        return view('draf.index', compact('drafs'));
    }

    public function create()
    {
        $documentTypes = DocumentType::active()->get();

        return view('draf.create', compact('documentTypes'));
    }

    public function store(StoreDrafRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('attachment')) {
            $validated['attachment_path'] = $request->file('attachment')->store('drafs/attachments', 'public');
        }

        $validated['requested_by'] = Auth::id();
        $validated['status'] = DrafStatus::DRAFT->value;

        $draf = Draf::create($validated);
        $this->recordHistory($draf, 'Created', null, DrafStatus::DRAFT->value, 'Initial DRAF created.');

        return redirect()->route('draf.show', $draf)->with('success', 'DRAF created successfully.');
    }

    public function show(Draf $draf)
    {
        $this->authorize('view', $draf);

        $draf->load(['documentType', 'requestedBy', 'reviewedBy', 'approvedBy', 'document']);

        return view('draf.show', compact('draf'));
    }

    public function print(Draf $draf)
    {
        $this->authorize('view', $draf);

        $draf->load(['documentType', 'requestedBy', 'reviewedBy', 'approvedBy']);

        $pdf = Pdf::loadView('draf.print-form', compact('draf'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('draf-form-'.$draf->draf_number.'.pdf');
    }

    public function edit(Draf $draf)
    {
        $this->authorize('update', $draf);
        $documentTypes = DocumentType::active()->get();

        return view('draf.edit', compact('draf', 'documentTypes'));
    }

    public function update(UpdateDrafRequest $request, Draf $draf)
    {
        $this->authorize('update', $draf);

        $validated = $request->validated();

        if ($request->hasFile('attachment')) {
            if ($draf->attachment_path) {
                Storage::disk('public')->delete($draf->attachment_path);
            }
            $validated['attachment_path'] = $request->file('attachment')->store('drafs/attachments', 'public');
        }

        $oldStatus = $draf->status?->value ?? DrafStatus::DRAFT->value;
        $draf->fill($validated);
        $draf->save();

        $this->recordHistory($draf, 'Updated', $oldStatus, $draf->status?->value ?? $oldStatus, 'DRAF information updated.');

        return redirect()->route('draf.show', $draf)->with('success', 'DRAF updated successfully.');
    }

    public function submit(Draf $draf)
    {
        $this->authorize('submit', $draf);

        $oldStatus = $draf->status?->value;
        $draf->status = DrafStatus::SUBMITTED->value;
        $draf->save();

        $this->recordHistory($draf, 'Submitted', $oldStatus, $draf->status?->value ?? DrafStatus::SUBMITTED->value, 'DRAF submitted for review.');

        return redirect()->route('draf.show', $draf)->with('success', 'DRAF submitted for review.');
    }

    protected function recordHistory(Draf $draf, string $action, ?string $oldStatus, ?string $newStatus, ?string $remarks = null): void
    {
        DrafHistory::create([
            'draf_id' => $draf->id,
            'user_id' => Auth::id(),
            'action' => $action,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'remarks' => $remarks,
        ]);
    }
}
