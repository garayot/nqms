@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-2 text-sm text-slate-500">
                <a href="{{ route('admin.operations-manual.index') }}" class="hover:text-[#0f3d68]">Operations Manual</a>
                <span class="mx-2">&gt;</span>
                <span>Create Process Group</span>
            </div>
            <h1 class="text-3xl font-bold text-slate-900">Add Process Group</h1>
            <p class="mt-2 text-sm text-slate-600">Create a new top-level process group.</p>

            <form method="POST" action="{{ route('admin.operations-manual.process-groups.store') }}" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label for="process_group_name" class="mb-1.5 block text-sm font-medium text-slate-700">Process Group Name</label>
                    <input id="process_group_name" name="process_group_name" value="{{ old('process_group_name') }}" maxlength="255" required class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" class="rounded-lg bg-[#0f3d68] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#0b2f52]">Save</button>
                    <a href="{{ route('admin.operations-manual.index') }}" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-100">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
