@php
    $isEdit = isset($team);
@endphp

<form method="POST" action="{{ $isEdit ? route('admin.qms-teams.update', $team) : route('admin.qms-teams.store') }}" class="space-y-6">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div>
        <label for="team_name" class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Team Name</label>
        <input id="team_name" type="text" name="team_name" value="{{ old('team_name', $team->team_name ?? '') }}" placeholder="Knowledge Management Team" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-[#0f3d68]">
    </div>

    <div>
        <label for="abbreviation" class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Abbreviation</label>
        <input id="abbreviation" type="text" name="abbreviation" value="{{ old('abbreviation', $team->abbreviation ?? '') }}" placeholder="KMT" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-[#0f3d68]">
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <button type="submit" class="inline-flex items-center justify-center rounded-md bg-[#0f3d68] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#0b2f52]">
            {{ $isEdit ? 'Update Team' : 'Save Team' }}
        </button>
        <a href="{{ route('admin.qms-teams.index') }}" class="inline-flex items-center justify-center rounded-md border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Cancel</a>
    </div>
</form>