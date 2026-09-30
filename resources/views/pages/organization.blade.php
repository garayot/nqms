@extends('layouts.guest')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">QMS Teams</p>
                <h1 class="mt-2 text-3xl font-bold text-slate-900">Organization Overview</h1>
                <p class="mt-2 max-w-2xl text-sm text-slate-600">Browse the current QMS teams and open each organization chart.</p>
            </div>

            @auth
                @if (auth()->user()?->isAdmin())
                    <a href="{{ route('admin.qms-teams.index') }}" class="inline-flex items-center justify-center rounded-md bg-[#0f3d68] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#0b2f52]">
                        Manage Teams
                    </a>
                @endif
            @endauth
        </div>

        @if ($teams->isEmpty())
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center shadow-sm">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-500">No teams yet</p>
                <p class="mt-2 text-sm text-slate-600">Teams will appear here once administrators create them.</p>
            </div>
        @else
            <div class="grid gap-6 lg:grid-cols-2 xl:grid-cols-3">
                @foreach ($teams as $team)
                    <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">QMS Team</p>
                                <h2 class="mt-2 text-xl font-bold text-slate-900">{{ $team->team_name }}</h2>
                                <div class="mt-2 inline-flex rounded-full bg-[#0f3d68]/10 px-3 py-1 text-xs font-semibold text-[#0f3d68]">{{ $team->abbreviation }}</div>
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
                            <a href="{{ route('organization.show', $team) }}" class="inline-flex items-center justify-center rounded-md bg-[#0f3d68] px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#0b2f52]">
                                View Organization Chart
                            </a>

                            @if (auth()->user()?->isAdmin())
                                <a href="{{ route('admin.qms-teams.show', $team) }}" class="inline-flex items-center justify-center rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                                    Manage
                                </a>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
@endsection
