<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DrafStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewDrafRequest;
use App\Models\Draf;
use App\Models\DrafHistory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DrafManagementController extends Controller
{
    public function index(Request $request)
    {
        $routePrefix = $this->routePrefix($request);
        $pageTitle = $routePrefix === 'reviewer' ? 'Review DRAFs' : 'Admin: DRAFs';
        $pageDescription = $routePrefix === 'reviewer'
            ? 'Review submitted DRAFs and record the review decision.'
            : 'Monitor, review, and manage all submissions.';

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

        return view('admin.drafs.index', compact('drafs', 'routePrefix', 'pageTitle', 'pageDescription'));
    }

    public function show(Request $request, Draf $draf)
    {
        $routePrefix = $this->routePrefix($request);
        $pageTitle = $routePrefix === 'reviewer' ? 'Review DRAFs' : 'Admin: DRAFs';

        $draf->load(['documentType', 'requestedBy', 'reviewedBy', 'approvedBy', 'document', 'histories.user', 'reasonOption']);

        return view('admin.drafs.show', compact('draf', 'routePrefix', 'pageTitle'));
    }

    public function print(Draf $draf)
    {
        $draf->load(['documentType', 'requestedBy', 'reviewedBy', 'approvedBy', 'reasonOption']);

        $pdf = Pdf::loadView('draf.print-form', compact('draf'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('draf-form-'.$draf->draf_number.'.pdf');
    }

    public function edit(Draf $draf)
    {
        $draf->load(['documentType', 'requestedBy']);

        return view('admin.drafs.edit', compact('draf'));
    }

    public function update(Request $request, Draf $draf)
    {
        $validated = $request->validate([
            'draf_number' => ['nullable', 'string', 'max:255', Rule::unique('drafs', 'draf_number')->ignore($draf->id)],
            'reference_code' => ['nullable', 'string', 'max:255'],
        ]);

        $draf->draf_number = $validated['draf_number'] ?? null;
        $draf->reference_code = $validated['reference_code'] ?? null;
        $draf->save();

        return redirect()->route('admin.form-templates.index')->with('success', 'DRAF details updated successfully.');
    }

    public function review(ReviewDrafRequest $request, Draf $draf)
    {
        $validated = $request->validated();
        $oldStatus = $draf->status?->value;
        $routePrefix = $this->routePrefix($request);

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

        return redirect()->route($routePrefix.'.drafs.show', $draf)->with('success', 'Review decision recorded.');
    }

    protected function routePrefix(Request $request): string
    {
        return $request->routeIs('reviewer.*') ? 'reviewer' : 'admin';
    }
}
