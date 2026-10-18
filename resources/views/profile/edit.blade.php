@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-2xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-6">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Profile</p>
            <h1 class="mt-2 text-3xl font-bold text-slate-900">Manage Profile</h1>
            <p class="mt-2 text-sm text-slate-600">Update your office, functional division, and position.</p>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="office_id" class="mb-1.5 block text-sm font-medium text-slate-700">Office</label>
                <select id="office_id" name="office_id" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                    <option value="">No office</option>
                    @foreach ($offices as $office)
                        <option value="{{ $office->id }}" @selected((string) old('office_id', auth()->user()->office_id) === (string) $office->id)>{{ $office->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="functional_div_id" class="mb-1.5 block text-sm font-medium text-slate-700">Functional Division</label>
                <select id="functional_div_id" name="functional_div_id" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                    <option value="">No functional division</option>
                    @foreach ($functionalDivs as $functionalDiv)
                        <option value="{{ $functionalDiv->id }}" @selected((string) old('functional_div_id', auth()->user()->functional_div_id) === (string) $functionalDiv->id)>{{ $functionalDiv->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="position_id" class="mb-1.5 block text-sm font-medium text-slate-700">Position</label>
                <select id="position_id" name="position_id" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                    <option value="">No position</option>
                    @foreach ($positions as $position)
                        <option value="{{ $position->id }}" @selected((string) old('position_id', auth()->user()->position_id) === (string) $position->id)>{{ $position->position_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="rounded-lg bg-[#0f3d68] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#0b2f52]">Save Changes</button>
            </div>
        </form>
    </div>
@endsection
