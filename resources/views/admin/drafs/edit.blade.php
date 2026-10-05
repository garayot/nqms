@extends('layouts.app')

@section('content')
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-slate-900">Edit DRAF Details</h1>
            <p class="mt-2 text-sm text-slate-600">Update DRAF number and reference code for document registration.</p>
        </div>

        <div class="mb-6 rounded-lg border border-slate-300 bg-slate-50 p-4">
            <h3 class="font-semibold text-slate-900">Document Information</h3>
            <dl class="mt-3 space-y-2 text-sm text-slate-600">
                <div class="flex justify-between"><dt class="font-medium">Title:</dt><dd>{{ $draf->title }}</dd></div>
                <div class="flex justify-between"><dt class="font-medium">Document Type:</dt><dd>{{ $draf->documentType?->name }}</dd></div>
                <div class="flex justify-between"><dt class="font-medium">Requested By:</dt><dd>{{ $draf->requestedBy?->name }}</dd></div>
                <div class="flex justify-between"><dt class="font-medium">Request Date:</dt><dd>{{ $draf->date_requested?->format('M d, Y') }}</dd></div>
            </dl>
        </div>

        <form method="POST" action="{{ route('admin.drafs.update', $draf) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid gap-6 lg:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">DRAF Number</label>
                    <input type="text" name="draf_number" value="{{ old('draf_number', $draf->draf_number) }}" placeholder="e.g., DRAF-2026-001" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                    @error('draf_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Reference Code</label>
                    <input type="text" name="reference_code" value="{{ old('reference_code', $draf->reference_code) }}" placeholder="e.g., BCD-HR-001" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                    @error('reference_code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.form-templates.index') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Cancel</a>
                <button type="submit" class="rounded-md bg-[#0f3d68] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#0b2f52]">Update DRAF</button>
            </div>
        </form>
    </div>
@endsection
