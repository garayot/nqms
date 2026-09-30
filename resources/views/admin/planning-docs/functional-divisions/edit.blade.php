@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-2 text-sm text-slate-500">
                <a href="{{ route('admin.planning-docs.index') }}" class="hover:text-[#0f3d68]">Planning Documents</a>
                <span class="mx-2">&gt;</span>
                <span>Edit Functional Division</span>
            </div>
            <h1 class="text-3xl font-bold text-slate-900">Edit Functional Division</h1>
            <p class="mt-2 text-sm text-slate-600">Update functional division details.</p>

            <form method="POST" action="{{ route('admin.planning-docs.functional-divisions.update', $functionalDiv) }}" class="mt-6 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="mb-1.5 block text-sm font-medium text-slate-700">Functional Division Name</label>
                    <input id="name" name="name" value="{{ old('name', $functionalDiv->name) }}" maxlength="255" required class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                </div>

                <div>
                    <label for="url" class="mb-1.5 block text-sm font-medium text-slate-700">Division Reference / Drive Link (Optional)</label>
                    <input id="url" name="url" value="{{ old('url', $functionalDiv->url) }}" maxlength="2048" placeholder="https://drive.google.com/..." class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" class="rounded-lg bg-[#0f3d68] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#0b2f52]">Update</button>
                    <a href="{{ route('admin.planning-docs.index') }}" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-100">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection