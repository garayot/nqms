@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-2 text-sm text-slate-500">
                <a href="{{ route('admin.operations-manual.index') }}" class="hover:text-[#0f3d68]">Operations Manual</a>
                <span class="mx-2">&gt;</span>
                <a href="{{ route('admin.operations-manual.processes.index', $processGroup) }}" class="hover:text-[#0f3d68]">{{ $processGroup->process_group_name }}</a>
                <span class="mx-2">&gt;</span>
                <a href="{{ route('admin.operations-manual.sub-processes.index', [$processGroup, $process]) }}" class="hover:text-[#0f3d68]">{{ $process->process_name }}</a>
                <span class="mx-2">&gt;</span>
                <span>Edit Sub-Process</span>
            </div>
            <h1 class="text-3xl font-bold text-slate-900">Edit Sub-Process</h1>
            <p class="mt-2 text-sm text-slate-600">Update sub-process details and QCP link.</p>

            <form method="POST" action="{{ route('admin.operations-manual.sub-processes.update', [$processGroup, $process, $subProcess]) }}" class="mt-6 space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" name="process_id" value="{{ $process->id }}">

                <div>
                    <label for="sub_process_name" class="mb-1.5 block text-sm font-medium text-slate-700">Sub-Process Name</label>
                    <input id="sub_process_name" name="sub_process_name" value="{{ old('sub_process_name', $subProcess->sub_process_name) }}" maxlength="255" required class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                </div>

                <div>
                    <label for="url" class="mb-1.5 block text-sm font-medium text-slate-700">QCP Link (Optional)</label>
                    <input id="url" name="url" value="{{ old('url', $subProcess->url) }}" maxlength="2048" placeholder="https://example.com" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" class="rounded-lg bg-[#0f3d68] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#0b2f52]">Update</button>
                    <a href="{{ route('admin.operations-manual.sub-processes.index', [$processGroup, $process]) }}" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-100">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
