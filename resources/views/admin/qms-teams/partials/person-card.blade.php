@php
    $user = $assignment->user;
@endphp

<article class="rounded-2xl border border-slate-200 bg-slate-50 p-5 shadow-sm transition hover:border-[#0f3d68]/30 hover:bg-white">
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0">
            <h3 class="truncate text-base font-bold text-slate-900">{{ $user->name }}</h3>
            <p class="mt-1 text-sm text-slate-600">{{ $user->position?->position_name ?? 'No position assigned' }}</p>
            <div class="mt-3 inline-flex rounded-full bg-[#0f3d68]/10 px-3 py-1 text-xs font-semibold text-[#0f3d68]">{{ $roleLabel }}</div>
        </div>

        @if ($isAdmin)
            <form method="POST" action="{{ $removeAction }}" onsubmit="return confirm('Remove {{ $user->name }} from this team role?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center justify-center rounded-md border border-rose-200 px-3 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-50">
                    Remove
                </button>
            </form>
        @endif
    </div>
</article>