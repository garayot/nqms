@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">DRAF Details</div>
                    <h1 class="mt-2 text-3xl font-bold text-slate-900">{{ $draf->title }}</h1>
                </div>
                <div class="flex gap-3">
                    <x-status-badge :status="$draf->status?->value ?? 'draft'" />
                    @if (auth()->user()->id === $draf->requested_by && $draf->isEditable())
                        <a href="{{ route('draf.edit', $draf) }}" class="rounded-md border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700">Edit</a>
                    @endif
                    @if (auth()->user()->id === $draf->requested_by && $draf->status === App\Enums\DrafStatus::DRAFT)
                        <form method="POST" action="{{ route('draf.submit', $draf) }}">
                            @csrf
                            <button type="submit" class="rounded-md bg-[#0f3d68] px-4 py-2 text-sm font-semibold text-white">Submit for Review</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-xl font-semibold text-slate-900">Request Information</h2>
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
                    <div class="flex justify-between gap-4"><dt>Attachment</dt><dd>{{ $draf->attachment_path ? 'Available' : 'No attachment' }}</dd></div>
                </dl>
                @if ($draf->attachment_path)
                    <a href="{{ Storage::url($draf->attachment_path) }}" target="_blank" class="mt-5 inline-flex rounded-md bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700">Open Attachment</a>
                @endif
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-xl font-semibold text-slate-900">Review & Approval Summary</h2>
                <dl class="mt-4 space-y-3 text-sm text-slate-600">
                    <div class="flex justify-between gap-4"><dt>Review Decision</dt><dd>{{ $draf->review?->label() ?? 'Pending' }}</dd></div>
                    <div class="flex justify-between gap-4"><dt>Reviewer</dt><dd>{{ $draf->reviewedBy?->name ?? 'Pending' }}</dd></div>
                    <div class="flex justify-between gap-4"><dt>Approval Decision</dt><dd>{{ $draf->approval?->label() ?? 'Pending' }}</dd></div>
                    <div class="flex justify-between gap-4"><dt>Approver</dt><dd>{{ $draf->approvedBy?->name ?? 'Pending' }}</dd></div>
                    <div class="flex justify-between gap-4"><dt>New Revision</dt><dd>{{ $draf->new_revision_number ?? '—' }}</dd></div>
                    <div class="flex justify-between gap-4"><dt>Effectivity</dt><dd>{{ $draf->effectivity_date?->format('M d, Y') ?? '—' }}</dd></div>
                </dl>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-slate-900">Status Timeline</h2>
            <div class="mt-6 space-y-4">
                @php
                    $timeline = [
                        ['Draft Created', $draf->created_at, 'draft'],
                        ['Submitted', $draf->updated_at, $draf->status?->value],
                        ['Under Review', $draf->reviewed_at, $draf->review?->value],
                        ['Review Decision', $draf->reviewed_at, $draf->review?->value],
                        ['Approval Decision', $draf->approved_at, $draf->approval?->value],
                        ['Registered', $draf->date_registered, $draf->date_registered ? 'registered' : 'pending'],
                    ];
                @endphp

                @foreach ($timeline as $step)
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="h-3 w-3 rounded-full bg-[#0f3d68]"></div>
                            @unless ($loop->last)
                                <div class="mt-1 h-full w-px bg-slate-200"></div>
                            @endunless
                        </div>
                        <div class="flex-1 rounded-lg border border-slate-200 bg-slate-50 p-3">
                            <div class="flex items-center justify-between gap-3">
                                <div class="font-semibold text-slate-800">{{ $step[0] }}</div>
                                <div class="text-xs text-slate-500">{{ $step[1] ? $step[1]->format('M d, Y') : 'Pending' }}</div>
                            </div>
                            <div class="mt-2 text-sm text-slate-600">{{ $step[2] ?? 'Pending' }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
