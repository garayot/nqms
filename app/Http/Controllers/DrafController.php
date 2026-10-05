<?php

namespace App\Http\Controllers;

use App\Enums\DrafStatus;
use App\Http\Requests\StoreDrafRequest;
use App\Http\Requests\UpdateDrafRequest;
use App\Models\DocumentType;
use App\Models\Draf;
use App\Models\DrafHistory;
use App\Models\Reason;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

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
        $reasons = Reason::query()->orderBy('name')->get();

        return view('draf.create', compact('documentTypes', 'reasons'));
    }

    public function store(StoreDrafRequest $request)
    {
        $validated = $request->validated();

        // Handle attachment URL instead of file
        if ($request->filled('attachment_url')) {
            $validated['attachment_url'] = $request->input('attachment_url');
        }

        // Handle open-ended reason if no predefined reason selected
        if (! $request->filled('reason_id') && $request->filled('open_ended_reason')) {
            $validated['open_ended_reason'] = $request->input('open_ended_reason');
            $validated['reason'] = $request->input('open_ended_reason');
        } else {
            $validated['open_ended_reason'] = null;
            $validated['reason'] = null;
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

        $draf->load(['documentType', 'requestedBy', 'reviewedBy', 'approvedBy', 'document', 'reasonOption']);

        return view('draf.show', compact('draf'));
    }

    public function print(Draf $draf)
    {
        $this->authorize('view', $draf);

        $draf->load(['documentType', 'requestedBy', 'reviewedBy', 'approvedBy', 'reasonOption']);

        $pdf = Pdf::loadView('draf.print-form', compact('draf'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('draf-form-'.$draf->draf_number.'.pdf');
    }

    public function edit(Draf $draf)
    {
        $this->authorize('update', $draf);
        $documentTypes = DocumentType::active()->get();
        $reasons = Reason::query()->orderBy('name')->get();

        return view('draf.edit', compact('draf', 'documentTypes', 'reasons'));
    }

    public function update(UpdateDrafRequest $request, Draf $draf)
    {
        $this->authorize('update', $draf);

        $validated = $request->validated();

        // Handle attachment URL instead of file
        if ($request->filled('attachment_url')) {
            $validated['attachment_url'] = $request->input('attachment_url');
        }

        // Handle open-ended reason if no predefined reason selected
        if (! $request->filled('reason_id') && $request->filled('open_ended_reason')) {
            $validated['open_ended_reason'] = $request->input('open_ended_reason');
            $validated['reason'] = $request->input('open_ended_reason');
        } else {
            $validated['open_ended_reason'] = null;
            $validated['reason'] = null;
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
