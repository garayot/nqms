@extends('layouts.app')

@section('content')
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-slate-900">Create DRAF</h1>
            <p class="mt-2 text-sm text-slate-600">Complete Section 1 of the Document Review and Approval Form.</p>
        </div>

        <form method="POST" action="{{ route('draf.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid gap-6 lg:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">DRAF Number</label>
                    <input name="draf_number" value="{{ old('draf_number') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Source</label>
                    <select name="source" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                        <option value="">Select</option>
                        <option value="internal" {{ old('source') == 'internal' ? 'selected' : '' }}>Internal</option>
                        <option value="external" {{ old('source') == 'external' ? 'selected' : '' }}>External</option>
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Request For</label>
                    <select name="request_for" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                        <option value="">Select</option>
                        <option value="creation" {{ old('request_for') == 'creation' ? 'selected' : '' }}>Creation</option>
                        <option value="revision" {{ old('request_for') == 'revision' ? 'selected' : '' }}>Revision</option>
                        <option value="disposition" {{ old('request_for') == 'disposition' ? 'selected' : '' }}>Disposition / Deletion</option>
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Document Type</label>
                    <select name="doc_type_id" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                        <option value="">Select</option>
                        @foreach ($documentTypes as $documentType)
                            <option value="{{ $documentType->id }}" {{ old('doc_type_id') == $documentType->id ? 'selected' : '' }}>{{ $documentType->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Applicability</label>
                    <select name="applicability" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                        <option value="">Select</option>
                        <option value="co" {{ old('applicability') == 'co' ? 'selected' : '' }}>Central Office</option>
                        <option value="ro" {{ old('applicability') == 'ro' ? 'selected' : '' }}>Regional Office</option>
                        <option value="sdo" {{ old('applicability') == 'sdo' ? 'selected' : '' }}>Schools Division Office</option>
                        <option value="school" {{ old('applicability') == 'school' ? 'selected' : '' }}>School</option>
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Title</label>
                    <input name="title" value="{{ old('title') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Reference Code</label>
                    <input name="reference_code" value="{{ old('reference_code') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Current Revision Number</label>
                    <input name="current_revision_no" value="{{ old('current_revision_no') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Requested By</label>
                    <input name="requested_by" value="{{ old('requested_by', auth()->id()) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Date Requested</label>
                    <input type="date" name="date_requested" value="{{ old('date_requested', now()->toDateString()) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                </div>
                <div class="lg:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-slate-700">Reason</label>
                    <textarea name="reason" rows="4" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">{{ old('reason') }}</textarea>
                </div>
                <div class="lg:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-slate-700">Attachment</label>
                    <input type="file" name="attachment" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('draf.index') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700">Cancel</a>
                <button type="submit" class="rounded-md bg-[#0f3d68] px-5 py-2.5 text-sm font-semibold text-white">Save DRAF</button>
            </div>
        </form>
    </div>
@endsection
