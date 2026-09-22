@props(['status'])
@php
    $statusClass = match ($status) {
        'draft' => 'bg-slate-100 text-slate-700',
        'submitted' => 'bg-blue-100 text-blue-700',
        'under_review' => 'bg-amber-100 text-amber-700',
        'recommended_for_approval' => 'bg-indigo-100 text-indigo-700',
        'review_disapproved' => 'bg-rose-100 text-rose-700',
        'approved' => 'bg-emerald-100 text-emerald-700',
        'approval_disapproved' => 'bg-red-100 text-red-700',
        'registered' => 'bg-cyan-100 text-cyan-700',
        default => 'bg-gray-100 text-gray-700',
    };
@endphp

<span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClass }}">
    {{ ucfirst(str_replace('_', ' ', $status ?? 'pending')) }}
</span>
