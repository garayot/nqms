@extends('layouts.app')

@section('content')
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-slate-900">Edit DRAF</h1>
            <p class="mt-2 text-sm text-slate-600">Update Section 1 values before the document is re-submitted.</p>
        </div>

        <form method="POST" action="{{ route('draf.update', $draf) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid gap-6 lg:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">DRAF Number</label>
                    <input name="draf_number" value="{{ old('draf_number', $draf->draf_number) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Source</label>
                    <select name="source" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                        <option value="internal" {{ old('source', $draf->source?->value ?? $draf->source) == 'internal' ? 'selected' : '' }}>Internal</option>
                        <option value="external" {{ old('source', $draf->source?->value ?? $draf->source) == 'external' ? 'selected' : '' }}>External</option>
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Request For</label>
                    <select name="request_for" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                        <option value="creation" {{ old('request_for', $draf->request_for?->value ?? $draf->request_for) == 'creation' ? 'selected' : '' }}>Creation</option>
                        <option value="revision" {{ old('request_for', $draf->request_for?->value ?? $draf->request_for) == 'revision' ? 'selected' : '' }}>Revision</option>
                        <option value="disposition" {{ old('request_for', $draf->request_for?->value ?? $draf->request_for) == 'disposition' ? 'selected' : '' }}>Disposition / Deletion</option>
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Document Type</label>
                    <select name="doc_type_id" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                        @foreach ($documentTypes as $documentType)
                            <option value="{{ $documentType->id }}" {{ old('doc_type_id', $draf->doc_type_id) == $documentType->id ? 'selected' : '' }}>{{ $documentType->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Applicability</label>
                    <select name="applicability" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                        <option value="co" {{ old('applicability', $draf->applicability?->value ?? $draf->applicability) == 'co' ? 'selected' : '' }}>Central Office</option>
                        <option value="ro" {{ old('applicability', $draf->applicability?->value ?? $draf->applicability) == 'ro' ? 'selected' : '' }}>Regional Office</option>
                        <option value="sdo" {{ old('applicability', $draf->applicability?->value ?? $draf->applicability) == 'sdo' ? 'selected' : '' }}>Schools Division Office</option>
                        <option value="school" {{ old('applicability', $draf->applicability?->value ?? $draf->applicability) == 'school' ? 'selected' : '' }}>School</option>
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Title</label>
                    <input name="title" value="{{ old('title', $draf->title) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Reference Code</label>
                    <input name="reference_code" value="{{ old('reference_code', $draf->reference_code) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Current Revision Number</label>
                    <input name="current_revision_no" value="{{ old('current_revision_no', $draf->current_revision_no) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Requested By</label>
                    <input name="requested_by" value="{{ old('requested_by', $draf->requested_by) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Date Requested</label>
                    <input type="date" name="date_requested" value="{{ old('date_requested', $draf->date_requested?->format('Y-m-d')) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                </div>
                <div class="lg:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-slate-700">Reason</label>
                    <textarea name="reason" rows="4" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">{{ old('reason', $draf->reason) }}</textarea>
                </div>
                <div class="lg:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-slate-700">Attachment</label>
                    <input type="file" name="attachment" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                    @if ($draf->attachment_path)
                        <div class="mt-2 text-xs text-slate-500">Current file: {{ basename($draf->attachment_path) }}</div>
                    @endif
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('draf.show', $draf) }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700">Cancel</a>
                <button type="submit" class="rounded-md bg-[#0f3d68] px-5 py-2.5 text-sm font-semibold text-white">Update DRAF</button>
            </div>
        </form>
    </div>
@endsection
