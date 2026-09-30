@php
    $isEdit = isset($position);
@endphp

<form method="POST" action="{{ $isEdit ? route('admin.positions.update', $position) : route('admin.positions.store') }}" class="space-y-6">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div>
        <label for="position_name" class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Position Name</label>
        <input id="position_name" type="text" name="position_name" value="{{ old('position_name', $position->position_name ?? '') }}" placeholder="PDO I" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-[#0f3d68]">
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <button type="submit" class="inline-flex items-center justify-center rounded-md bg-[#0f3d68] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#0b2f52]">
            {{ $isEdit ? 'Update Position' : 'Save Position' }}
        </button>
        <a href="{{ route('admin.positions.index') }}" class="inline-flex items-center justify-center rounded-md border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Cancel</a>
    </div>
</form>