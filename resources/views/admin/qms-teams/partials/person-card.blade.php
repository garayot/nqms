@php
    $user = $assignment->user;
@endphp

<article class="flex w-full max-w-sm flex-col rounded-2xl border border-slate-200 bg-slate-50 p-5 shadow-sm transition hover:border-[#0f3d68]/30 hover:bg-white">
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0">
            <h3 class="truncate text-base font-bold text-slate-900">{{ $user->name }}</h3>
            <p class="mt-1 text-sm text-slate-600">{{ $user->position?->position_name ?? 'No position assigned' }}</p>
            <div class="mt-3 inline-flex rounded-full bg-[#0f3d68]/10 px-3 py-1 text-xs font-semibold text-[#0f3d68]">{{ $roleLabel }}</div>
        </div>

        <div class="flex shrink-0 items-center justify-center">
            @if (! empty($avatarUrl))
                <img src="{{ $avatarUrl }}" alt="{{ $user->name }}" class="h-16 w-16 rounded-full border border-slate-200 object-cover shadow-sm">
            @else
                <div class="flex h-16 w-16 items-center justify-center rounded-full border border-slate-200 bg-slate-200 text-sm font-bold text-slate-700 shadow-sm">
                    {{ \Illuminate\Support\Str::of($user->name)->trim()->explode(' ')->take(2)->map(fn ($part) => \Illuminate\Support\Str::substr($part, 0, 1))->implode('') }}
                </div>
            @endif
        </div>
    </div>

    @if ($isAdmin)
        <div class="mt-4 flex justify-start">
            <form method="POST" action="{{ $removeAction }}" onsubmit="return confirm('Remove {{ $user->name }} from this team role?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center justify-center rounded-md border border-rose-200 px-3 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-50">
                    Remove
                </button>
            </form>
        </div>
    @endif
</article>