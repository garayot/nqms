<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DrafStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewDrafRequest;
use App\Models\Draf;
use App\Models\DrafHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DrafManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Draf::with(['requestedBy', 'documentType'])
            ->when($request->search, function ($q, $search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('draf_number', 'like', "%{$search}%")
                        ->orWhere('title', 'like', "%{$search}%")
                        ->orWhere('reference_code', 'like', "%{$search}%");
                });
            })
            ->when($request->status, fn ($q, $status) => $q->where('status', $status))
            ->when($request->doc_type_id, fn ($q, $id) => $q->where('doc_type_id', $id))
            ->when($request->applicability, fn ($q, $value) => $q->where('applicability', $value))
            ->when($request->source, fn ($q, $value) => $q->where('source', $value));

        $drafs = $query->latest()->paginate(12)->withQueryString();

        return view('admin.drafs.index', compact('drafs'));
    }

    public function show(Draf $draf)
    {
        $draf->load(['documentType', 'requestedBy', 'reviewedBy', 'approvedBy', 'document', 'histories.user']);

        return view('admin.drafs.show', compact('draf'));
    }

    public function review(ReviewDrafRequest $request, Draf $draf)
    {
        $validated = $request->validated();
        $oldStatus = $draf->status?->value;

        $draf->review = $validated['review'];
        $draf->reason1 = $validated['reason1'] ?? null;
        $draf->reviewed_by = $validated['reviewed_by'];
        $draf->reviewed_at = $validated['reviewed_at'];
        $draf->status = $validated['review'] === 'disapproved'
            ? DrafStatus::REVIEW_DISAPPROVED->value
            : DrafStatus::RECOMMENDED_FOR_APPROVAL->value;
        $draf->save();

        DrafHistory::create([
            'draf_id' => $draf->id,
            'user_id' => Auth::id(),
            'action' => $validated['review'] === 'disapproved' ? 'Review Disapproved' : 'Recommended for Approval',
            'old_status' => $oldStatus,
            'new_status' => $draf->status,
            'remarks' => $validated['reason1'] ?? null,
        ]);

        return redirect()->route('admin.drafs.show', $draf)->with('success', 'Review decision recorded.');
    }
}
