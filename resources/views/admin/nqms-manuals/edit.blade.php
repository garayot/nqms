@extends('layouts.app')

@section('content')
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-slate-900">Edit NQMS Manual</h1>
            <p class="mt-2 text-sm text-slate-600">Update the selected NQMS manual repository entry.</p>
        </div>

        <form method="POST" action="{{ route('admin.nqms-manuals.update', $nqmsManual) }}" class="grid gap-4 md:grid-cols-2">
            @csrf
            @method('PUT')

            <div>
                <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Document Type</label>
                <select name="document_type_id" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm" required>
                    @foreach ($documentTypes as $documentType)
                        <option value="{{ $documentType->id }}" @selected(old('document_type_id', $nqmsManual->document_type_id) == $documentType->id)>{{ $documentType->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Document Reference Code</label>
                <input name="document_reference_code" value="{{ old('document_reference_code', $nqmsManual->document_reference_code) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm" required>
            </div>
            <div>
                <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Doc Title</label>
                <input name="doc_title" value="{{ old('doc_title', $nqmsManual->doc_title) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm" required>
            </div>
            <div>
                <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Originating Office</label>
                <select name="responsible" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm" required>
                    @foreach ($functionalDivisions as $functionalDivision)
                        <option value="{{ $functionalDivision->name }}" @selected(old('responsible', $nqmsManual->responsible) === $functionalDivision->name)>{{ $functionalDivision->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Revision Number</label>
                <input name="revision_number" value="{{ old('revision_number', $nqmsManual->revision_number) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
            </div>
            <div>
                <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Effectivity Date</label>
                <input type="date" name="effectivity_date" value="{{ old('effectivity_date', optional($nqmsManual->effectivity_date)->format('Y-m-d')) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
            </div>
            <div>
                <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Document Location</label>
                <select name="document_location" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                    <option value="">Select document location</option>
                    @foreach ($offices as $office)
                        <option value="{{ $office->name }}" @selected(old('document_location', $nqmsManual->document_location) === $office->name)>{{ $office->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Doc Status</label>
                <select name="status" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm" required>
                    <option value="active" @selected(old('status', $nqmsManual->status?->value) === 'active')>Active</option>
                    <option value="obsolete" @selected(old('status', $nqmsManual->status?->value) === 'obsolete')>Obsolete</option>
                </select>
            </div>
            <div>
                <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Downloadable Attachment URL</label>
                <input type="url" name="downloadable_attachment_url" value="{{ old('downloadable_attachment_url', $nqmsManual->downloadable_attachment_url) }}" placeholder="https://example.com/file.pdf" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
            </div>

            <div class="md:col-span-2 flex justify-end gap-3">
                <a href="{{ route('admin.nqms-manuals.index') }}" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</a>
                <button type="submit" class="rounded-lg bg-[#0f3d68] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#0b2f52]">Update NQMS Manual</button>
            </div>
        </form>
    </div>
@endsection
