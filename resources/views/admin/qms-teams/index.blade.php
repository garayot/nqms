@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Administration</p>
                    <h1 class="mt-2 text-3xl font-bold text-slate-900">QMS Teams</h1>
                    <p class="mt-2 text-sm text-slate-600">Create and manage teams, then open each chart to assign members.</p>
                </div>

                <a href="{{ route('admin.qms-teams.create') }}" class="inline-flex items-center justify-center rounded-md bg-[#0f3d68] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#0b2f52]">
                    + Add Team
                </a>
            </div>
        </div>

        @if ($teams->isEmpty())
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center shadow-sm">
                <p class="text-sm text-slate-500">No teams have been created yet.</p>
            </div>
        @else
            <div class="grid gap-6 lg:grid-cols-2 xl:grid-cols-2">
                @foreach ($teams as $team)
                    <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">QMS Team</p>
                                <h2 class="mt-2 text-xl font-bold text-slate-900">{{ $team->team_name }}</h2>
                                <div class="mt-2 inline-flex rounded-full bg-[#0f3d68]/10 px-3 py-1 text-xs font-semibold text-[#0f3d68]">{{ $team->abbreviation }}</div>
                            </div>

                            <div class="text-right text-xs uppercase tracking-[0.16em] text-slate-500">
                                Team ID {{ $team->id }}
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-3 gap-3 text-center text-sm">
                            <div class="rounded-xl bg-slate-50 px-3 py-4">
                                <div class="text-lg font-bold text-slate-900">{{ $team->team_leads_count }}</div>
                                <div class="mt-1 text-xs uppercase tracking-[0.14em] text-slate-500">Leads</div>
                            </div>
                            <div class="rounded-xl bg-slate-50 px-3 py-4">
                                <div class="text-lg font-bold text-slate-900">{{ $team->team_members_count }}</div>
                                <div class="mt-1 text-xs uppercase tracking-[0.14em] text-slate-500">Members</div>
                            </div>
                            <div class="rounded-xl bg-slate-50 px-3 py-4">
                                <div class="text-lg font-bold text-slate-900">{{ $team->team_secretariat_count }}</div>
                                <div class="mt-1 text-xs uppercase tracking-[0.14em] text-slate-500">Secretariat</div>
                            </div>
                        </div>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="{{ route('admin.qms-teams.show', $team) }}" class="inline-flex items-center justify-center rounded-md bg-[#0f3d68] px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#0b2f52]">
                                Manage
                            </a>
                            <a href="{{ route('admin.qms-teams.edit', $team) }}" class="inline-flex items-center justify-center rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.qms-teams.destroy', $team) }}" onsubmit="return confirm('Delete {{ $team->team_name }} and all of its assignments? Users will not be deleted.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center rounded-md border border-rose-200 px-4 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-50">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
@endsection