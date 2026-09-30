@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-3xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-6">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">QMS Teams</p>
            <h1 class="mt-2 text-3xl font-bold text-slate-900">Edit Team</h1>
        </div>

        @include('admin.qms-teams.partials.form', ['team' => $team])
    </div>
@endsection