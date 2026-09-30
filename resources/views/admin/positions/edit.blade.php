@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-2xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-6">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Positions</p>
            <h1 class="mt-2 text-3xl font-bold text-slate-900">Edit Position</h1>
        </div>

        @include('admin.positions.partials.form', ['position' => $position])
    </div>
@endsection