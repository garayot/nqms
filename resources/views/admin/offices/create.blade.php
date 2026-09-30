@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-2xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-6">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Offices</p>
            <h1 class="mt-2 text-3xl font-bold text-slate-900">Create Office</h1>
        </div>

        <form method="POST" action="{{ route('admin.offices.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="mb-1.5 block text-sm font-medium text-slate-700">Office Name</label>
                <input id="name" name="name" value="{{ old('name') }}" maxlength="255" required class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="rounded-lg bg-[#0f3d68] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#0b2f52]">Save</button>
                <a href="{{ route('admin.offices.index') }}" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-100">Cancel</a>
            </div>
        </form>
    </div>
@endsection
