@extends('layouts.app')

@section('content')
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-slate-900">Edit DRAF</h1>
            <p class="mt-2 text-sm text-slate-600">Update Section 1 values before the document is re-submitted.</p>
        </div>

        <form method="POST" action="{{ route('draf.update', $draf) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid gap-6 lg:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">DRAF Number <span class="text-slate-400">(Optional)</span></label>
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
                    <label class="mb-2 block text-sm font-medium text-slate-700">Reference Code <span class="text-slate-400">(Optional)</span></label>
                    <input name="reference_code" value="{{ old('reference_code', $draf->reference_code) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Current Revision Number</label>
                    <input name="current_revision_no" value="{{ old('current_revision_no', $draf->current_revision_no) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Requested By</label>
                    <input type="text" value="{{ $draf->requestedBy?->name }}" disabled class="w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2.5 text-sm text-slate-600">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Date Requested</label>
                    <input type="date" name="date_requested" value="{{ old('date_requested', $draf->date_requested?->format('Y-m-d')) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                </div>
                <div class="lg:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-slate-700">Reason</label>
                    <select name="reason_id" id="reason_select" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                        <option value="">Select a predefined reason or enter custom reason below</option>
                        @foreach ($reasons as $reason)
                            <option value="{{ $reason->id }}" {{ (string) old('reason_id', $draf->reason_id) === (string) $reason->id ? 'selected' : '' }}>{{ $reason->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="lg:col-span-2" id="custom_reason_field" style="display: none;">
                    <label class="mb-2 block text-sm font-medium text-slate-700">Custom Reason (Please specify)</label>
                    <textarea name="open_ended_reason" rows="4" placeholder="Enter your custom reason here..." class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">{{ old('open_ended_reason', $draf->open_ended_reason) }}</textarea>
                </div>
                <div class="lg:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-slate-700">Attachment URL</label>
                    <input type="url" name="attachment_url" value="{{ old('attachment_url', $draf->attachment_url) }}" placeholder="https://example.com/document.pdf" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                    <p class="mt-2 text-xs text-slate-500">Provide a URL link to the document or file</p>
                    @if ($draf->attachment_url)
                        <div class="mt-2">
                            <a href="{{ $draf->attachment_url }}" target="_blank" class="text-xs text-blue-600 hover:text-blue-800">Current URL</a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('draf.show', $draf) }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700">Cancel</a>
                <button type="submit" class="rounded-md bg-[#0f3d68] px-5 py-2.5 text-sm font-semibold text-white">Update DRAF</button>
            </div>
        </form>
    </div>

    <script>
        const reasonSelect = document.getElementById('reason_select');
        const customReasonField = document.getElementById('custom_reason_field');

        function toggleCustomReason() {
            if (reasonSelect.value === '') {
                customReasonField.style.display = 'block';
            } else {
                customReasonField.style.display = 'none';
            }
        }

        reasonSelect.addEventListener('change', toggleCustomReason);
        toggleCustomReason();
    </script>
@endsection
