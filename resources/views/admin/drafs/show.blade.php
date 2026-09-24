@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Review</div>
                    <h1 class="mt-2 text-3xl font-bold text-slate-900">{{ $draf->title }}</h1>
                </div>
                <div class="flex items-center gap-3">
                    <x-status-badge :status="$draf->status?->value ?? 'draft'" />
                    <a href="{{ route('admin.drafs.print', $draf) }}" target="_blank" class="rounded-md border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700">Print DRAF Form</a>
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-xl font-semibold text-slate-900">DRAF Information</h2>
                <dl class="mt-4 space-y-2 text-sm text-slate-600">
                    <div class="flex justify-between"><dt>DRAF Number</dt><dd>{{ $draf->draf_number }}</dd></div>
                    <div class="flex justify-between"><dt>Source</dt><dd>{{ $draf->source?->label() ?? $draf->source }}</dd></div>
                    <div class="flex justify-between"><dt>Document Type</dt><dd>{{ $draf->documentType?->name }}</dd></div>
                    <div class="flex justify-between"><dt>Requested By</dt><dd>{{ $draf->requestedBy?->name }}</dd></div>
                    <div class="flex justify-between"><dt>Reason</dt><dd>{{ $draf->reason }}</dd></div>
                    <div class="flex justify-between"><dt>Reference Code</dt><dd>{{ $draf->reference_code ?? 'N/A' }}</dd></div>
                    <div class="flex justify-between"><dt>Current Revision</dt><dd>{{ $draf->current_revision_no }}</dd></div>
                </dl>

                <div class="mt-5 flex flex-wrap gap-3">
                    @if ($draf->attachment_path)
                        <a href="{{ Storage::url($draf->attachment_path) }}" target="_blank" class="inline-flex rounded-md bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700">View Submitted Attachment</a>
                    @endif

                    @if ($draf->approved_attachment_path)
                        <a href="{{ Storage::url($draf->approved_attachment_path) }}" target="_blank" class="inline-flex rounded-md bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700">View Approved Attachment</a>
                    @endif
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-xl font-semibold text-slate-900">Review Decision</h2>
                <form method="POST" action="{{ route('admin.drafs.review', $draf) }}" class="mt-4 space-y-4">
                    @csrf
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Review</label>
                        <select name="review" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                            <option value="recommend_approval">Recommend Approval</option>
                            <option value="disapproved">Disapproved</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Reason for Review Decision</label>
                        <textarea name="reason1" rows="4" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm"></textarea>
                    </div>
                    <input type="hidden" name="reviewed_by" value="{{ auth()->id() }}">
                    <input type="hidden" name="reviewed_at" value="{{ now()->toDateTimeString() }}">
                    <button type="submit" class="rounded-md bg-[#0f3d68] px-5 py-2.5 text-sm font-semibold text-white">Submit Review</button>
                </form>
            </div>
        </div>
    </div>
@endsection
