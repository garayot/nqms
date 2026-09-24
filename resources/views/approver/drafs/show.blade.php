@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Approver Review</div>
                    <h1 class="mt-2 text-3xl font-bold text-slate-900">{{ $draf->title }}</h1>
                    <p class="mt-2 text-sm text-slate-600">Review the submitted DRAF details, inspect attachments, and record the approval decision.</p>
                </div>
                <x-status-badge :status="$draf->status?->value ?? 'draft'" />
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <div class="space-y-6">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-semibold text-slate-900">DRAF Details</h2>
                    <dl class="mt-4 space-y-3 text-sm text-slate-600">
                        <div class="flex justify-between gap-4"><dt>DRAF Number</dt><dd>{{ $draf->draf_number }}</dd></div>
                        <div class="flex justify-between gap-4"><dt>Source</dt><dd>{{ $draf->source?->label() ?? $draf->source }}</dd></div>
                        <div class="flex justify-between gap-4"><dt>Request For</dt><dd>{{ $draf->request_for?->label() ?? $draf->request_for }}</dd></div>
                        <div class="flex justify-between gap-4"><dt>Document Type</dt><dd>{{ $draf->documentType?->name ?? 'N/A' }}</dd></div>
                        <div class="flex justify-between gap-4"><dt>Applicability</dt><dd>{{ $draf->applicability?->label() ?? $draf->applicability }}</dd></div>
                        <div class="flex justify-between gap-4"><dt>Reference Code</dt><dd>{{ $draf->reference_code ?? 'N/A' }}</dd></div>
                        <div class="flex justify-between gap-4"><dt>Current Revision</dt><dd>{{ $draf->current_revision_no }}</dd></div>
                        <div class="flex justify-between gap-4"><dt>Requested By</dt><dd>{{ $draf->requestedBy?->name ?? 'N/A' }}</dd></div>
                        <div class="flex justify-between gap-4"><dt>Date Requested</dt><dd>{{ $draf->date_requested?->format('M d, Y') ?? 'N/A' }}</dd></div>
                    </dl>

                    <div class="mt-5 rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <div class="text-sm font-semibold text-slate-800">Reason</div>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ $draf->reason }}</p>
                    </div>

                    <div class="mt-5 flex flex-wrap gap-3">
                        @if ($draf->attachment_path)
                            <a href="{{ Storage::url($draf->attachment_path) }}" target="_blank" class="inline-flex rounded-md bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700">View Submitted Attachment</a>
                        @endif

                        @if ($draf->approved_attachment_path)
                            <a href="{{ Storage::url($draf->approved_attachment_path) }}" target="_blank" class="inline-flex rounded-md bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700">View Current Approved File</a>
                        @endif
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-semibold text-slate-900">Review Summary</h2>
                    <dl class="mt-4 space-y-3 text-sm text-slate-600">
                        <div class="flex justify-between gap-4"><dt>Review Decision</dt><dd>{{ $draf->review?->label() ?? 'Pending' }}</dd></div>
                        <div class="flex justify-between gap-4"><dt>Reviewed By</dt><dd>{{ $draf->reviewedBy?->name ?? 'N/A' }}</dd></div>
                        <div class="flex justify-between gap-4"><dt>Review Date</dt><dd>{{ $draf->reviewed_at?->format('M d, Y h:i A') ?? 'N/A' }}</dd></div>
                        <div class="flex justify-between gap-4"><dt>Review Remarks</dt><dd>{{ $draf->reason1 ?? 'N/A' }}</dd></div>
                    </dl>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-semibold text-slate-900">Approval Decision</h2>
                    <form method="POST" action="{{ route('approver.drafs.approve', $draf) }}" enctype="multipart/form-data" class="mt-4 space-y-4">
                        @csrf
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Approval</label>
                            <select name="approval" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                                <option value="approved" {{ old('approval', $draf->approval?->value ?? '') === 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="disapproved" {{ old('approval', $draf->approval?->value ?? '') === 'disapproved' ? 'selected' : '' }}>Disapproved</option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Reason for Approval Decision</label>
                            <textarea name="reason2" rows="4" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">{{ old('reason2', $draf->reason2) }}</textarea>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">New Revision Number</label>
                                <input name="new_revision_number" value="{{ old('new_revision_number', $draf->new_revision_number) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                            </div>
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">Effectivity Date</label>
                                <input type="date" name="effectivity_date" value="{{ old('effectivity_date', optional($draf->effectivity_date)->format('Y-m-d')) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                            </div>
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">Date Registered</label>
                                <input type="date" name="date_registered" value="{{ old('date_registered', optional($draf->date_registered)->format('Y-m-d')) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                            </div>
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">Approved Attachment</label>
                                <input type="file" name="approved_attachment" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                            </div>
                        </div>

                        <input type="hidden" name="approved_by" value="{{ auth()->id() }}">
                        <input type="hidden" name="approved_at" value="{{ now()->toDateTimeString() }}">

                        <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
                            For approval, provide at least the new revision number and effectivity date. If uploading the final approved document, also provide the registration date.
                        </div>

                        <button type="submit" class="rounded-md bg-[#0f3d68] px-5 py-2.5 text-sm font-semibold text-white">Apply Decision</button>
                    </form>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-semibold text-slate-900">Activity History</h2>
                    <div class="mt-4 space-y-4">
                        @forelse ($draf->histories as $history)
                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                                <div class="flex items-center justify-between gap-3">
                                    <div class="font-semibold text-slate-800">{{ $history->action }}</div>
                                    <div class="text-xs text-slate-500">{{ $history->created_at?->format('M d, Y h:i A') }}</div>
                                </div>
                                <div class="mt-2 text-sm text-slate-600">
                                    {{ $history->user?->name ?? 'System' }}
                                    @if ($history->old_status || $history->new_status)
                                        · {{ $history->old_status ?? '—' }} → {{ $history->new_status ?? '—' }}
                                    @endif
                                </div>
                                @if ($history->remarks)
                                    <div class="mt-2 text-sm text-slate-600">{{ $history->remarks }}</div>
                                @endif
                            </div>
                        @empty
                            <div class="rounded-xl border border-dashed border-slate-300 p-6 text-center text-slate-500">No activity history available.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
