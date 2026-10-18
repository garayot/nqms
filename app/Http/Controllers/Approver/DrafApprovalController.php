<?php

namespace App\Http\Controllers\Approver;

use App\Enums\ApprovalDecision;
use App\Enums\DocumentStatus;
use App\Enums\DrafStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApproveDrafRequest;
use App\Models\Document;
use App\Models\Draf;
use App\Models\DrafHistory;
use App\Models\FormTemplate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DrafApprovalController extends Controller
{
    public function index()
    {
        $drafs = Draf::with(['requestedBy', 'documentType'])
            ->whereIn('status', [
                DrafStatus::RECOMMENDED_FOR_APPROVAL->value,
                DrafStatus::APPROVED->value,
                DrafStatus::REGISTERED->value,
            ])
            ->latest()
            ->paginate(12);

        return view('approver.drafs.index', compact('drafs'));
    }

    public function show(Draf $draf)
    {
        $draf->load([
            'requestedBy',
            'reviewedBy',
            'approvedBy',
            'documentType',
            'document',
            'histories.user',
            'reasonOption',
        ]);

        return view('approver.drafs.show', compact('draf'));
    }

    public function print(Draf $draf)
    {
        $draf->load(['documentType', 'requestedBy', 'reviewedBy', 'approvedBy', 'reasonOption']);

        $pdf = Pdf::loadView('draf.print-form', compact('draf'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('draf-form-'.$draf->draf_number.'.pdf');
    }

    public function approve(ApproveDrafRequest $request, Draf $draf)
    {
        $validated = $request->validated();
        $oldStatus = $draf->status?->value;

        $draf->loadMissing([
            'documentType',
            'requestedBy.functionalDivLookup',
            'requestedBy.officeLookup',
        ]);

        $draf->approval = $validated['approval'];
        $draf->reason2 = $validated['reason2'] ?? null;
        $draf->approved_by = $validated['approved_by'];
        $draf->approved_at = $validated['approved_at'];
        $draf->new_revision_number = $validated['new_revision_number'] ?? $draf->current_revision_no;
        $draf->effectivity_date = $validated['effectivity_date'] ?? $draf->date_requested;
        $draf->date_registered = null;

        if ($validated['approval'] === ApprovalDecision::APPROVED->value) {
            $draf->status = DrafStatus::APPROVED->value;

            if (filled($validated['approved_attachment_url'] ?? null)) {
                $draf->approved_attachment_url = $validated['approved_attachment_url'];
                $draf->date_registered = $validated['date_registered'] ?? now()->toDateString();
                $draf->status = DrafStatus::REGISTERED->value;
                $document = $draf->document ?? new Document;
                $document->draf_id = $draf->id;
                $document->originating_office_id = $draf->requestedBy?->id;
                $document->status = DocumentStatus::ACTIVE->value;
                $document->downloadable_doc_path = $validated['approved_attachment_url'];
                $document->location = 'Repository';
                $document->save();

                if (Str::lower((string) $draf->documentType?->name) === 'forms/template') {
                    FormTemplate::updateOrCreate(
                        ['document_reference_code' => $draf->reference_code],
                        [
                            'document_type_id' => $draf->doc_type_id,
                            'doc_title' => $draf->title,
                            'responsible' => $draf->requestedBy?->functionalDivLookup?->name ?? 'Unassigned',
                            'revision_number' => $draf->new_revision_number ?? $draf->current_revision_no,
                            'effectivity_date' => $draf->effectivity_date ?? $draf->date_requested,
                            'document_location' => $draf->requestedBy?->officeLookup?->name ?? 'Unassigned',
                            'status' => 'active',
                            'downloadable_attachment_path' => $validated['approved_attachment_url'],
                            'created_by' => $validated['approved_by'],
                        ],
                    );
                }
            }
        } else {
            $draf->status = DrafStatus::APPROVAL_DISAPPROVED->value;
        }

        $draf->save();

        DrafHistory::create([
            'draf_id' => $draf->id,
            'user_id' => Auth::id(),
            'action' => $validated['approval'] === ApprovalDecision::APPROVED->value ? 'Approved' : 'Approval Disapproved',
            'old_status' => $oldStatus,
            'new_status' => $draf->status,
            'remarks' => $validated['reason2'] ?? null,
        ]);

        return redirect()->route('approver.drafs.show', $draf)->with('success', 'Approval decision recorded.');
    }
}
