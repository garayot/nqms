@extends('layouts.guest')

@section('content')
    @php
        $avatarUrl = function (?string $avatar): ?string {
            if (! filled($avatar)) {
                return null;
            }

            return \Illuminate\Support\Str::startsWith($avatar, ['http://', 'https://'])
                ? $avatar
                : \Illuminate\Support\Facades\Storage::url($avatar);
        };
    @endphp

    <div class="mx-auto flex min-h-[calc(100vh-8rem)] max-w-6xl flex-col items-center px-4 py-10 sm:px-6 lg:px-8">
        <div class="w-full rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col items-center gap-4 text-center">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">QMS Organization Chart</p>
                    <h1 class="mt-2 text-3xl font-bold text-slate-900">{{ $team->team_name }}</h1>
                    <div class="mt-3 inline-flex rounded-full bg-[#0f3d68]/10 px-3 py-1 text-sm font-semibold text-[#0f3d68]">{{ $team->abbreviation }}</div>
                </div>

                @if ($isAdmin)
                    <div class="flex flex-wrap justify-center gap-3">
                        <a href="{{ route('admin.qms-teams.edit', $team) }}" class="inline-flex items-center justify-center rounded-md border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Edit Team</a>
                        <form method="POST" action="{{ route('admin.qms-teams.destroy', $team) }}" onsubmit="return confirm('Delete {{ $team->team_name }} and all of its assignments? Users will not be deleted.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center rounded-md border border-rose-200 px-4 py-2.5 text-sm font-semibold text-rose-700 transition hover:bg-rose-50">Delete Team</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <div class="flex w-full flex-col items-center">
            <div class="my-8 h-10 w-px bg-slate-300"></div>

            <div class="w-full space-y-10">
                <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex flex-col items-center gap-4 text-center">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Team Leads</p>
                            <h2 class="mt-2 text-xl font-bold text-slate-900">{{ $team->roleLabel('Lead') }}</h2>
                        </div>
                    </div>

                    @if ($isAdmin)
                        <form method="POST" action="{{ route('admin.qms-teams.leads.store', $team) }}" class="mx-auto mt-6 grid max-w-2xl gap-3 sm:grid-cols-[minmax(0,1fr)_auto]">
                            @csrf
                            <input type="hidden" name="team_id" value="{{ $team->id }}">
                            <select name="user_id" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-[#0f3d68]">
                                <option value="">Select a user</option>
                                @foreach ($availableLeadUsers as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} — {{ $user->position?->position_name ?? 'No position' }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#0f3d68] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#0b2f52]">+ Add Lead</button>
                        </form>
                    @endif

                    <div class="mt-6 flex flex-wrap justify-center gap-4">
                        @forelse ($team->teamLeads as $assignment)
                            @include('admin.qms-teams.partials.person-card', [
                                'assignment' => $assignment,
                                'roleLabel' => $team->roleLabel('Lead'),
                                'removeAction' => route('admin.qms-teams.leads.destroy', [$team, $assignment]),
                                'isAdmin' => $isAdmin,
                                'avatarUrl' => $avatarUrl($assignment->user->avatar),
                            ])
                        @empty
                            <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-8 text-sm text-slate-500">
                                No team leads have been assigned.
                            </div>
                        @endforelse
                    </div>

                    @if ($isAdmin && $availableLeadUsers->isEmpty())
                        <p class="mt-4 text-center text-xs text-slate-500">No available users remain for this role.</p>
                    @endif
                </section>

                <div class="mx-auto flex h-10 w-px justify-center bg-slate-300"></div>

                <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex flex-col items-center gap-4 text-center">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Team Members</p>
                            <h2 class="mt-2 text-xl font-bold text-slate-900">{{ $team->roleLabel('Member') }}</h2>
                        </div>
                    </div>

                    @if ($isAdmin)
                        <form method="POST" action="{{ route('admin.qms-teams.members.store', $team) }}" class="mx-auto mt-6 grid max-w-2xl gap-3 sm:grid-cols-[minmax(0,1fr)_auto]">
                            @csrf
                            <input type="hidden" name="team_id" value="{{ $team->id }}">
                            <select name="user_id" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-[#0f3d68]">
                                <option value="">Select a user</option>
                                @foreach ($availableMemberUsers as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} — {{ $user->position?->position_name ?? 'No position' }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#0f3d68] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#0b2f52]">+ Add Member</button>
                        </form>
                    @endif

                    <div class="mt-6 flex flex-wrap justify-center gap-4">
                        @forelse ($team->teamMembers as $assignment)
                            @include('admin.qms-teams.partials.person-card', [
                                'assignment' => $assignment,
                                'roleLabel' => $team->roleLabel('Member'),
                                'removeAction' => route('admin.qms-teams.members.destroy', [$team, $assignment]),
                                'isAdmin' => $isAdmin,
                                'avatarUrl' => $avatarUrl($assignment->user->avatar),
                            ])
                        @empty
                            <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-8 text-sm text-slate-500">
                                No team members have been assigned.
                            </div>
                        @endforelse
                    </div>

                    @if ($isAdmin && $availableMemberUsers->isEmpty())
                        <p class="mt-4 text-center text-xs text-slate-500">No available users remain for this role.</p>
                    @endif
                </section>

                <div class="mx-auto flex h-10 w-px justify-center bg-slate-300"></div>

                <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex flex-col items-center gap-4 text-center">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Team Secretariat</p>
                            <h2 class="mt-2 text-xl font-bold text-slate-900">{{ $team->roleLabel('Secretariat') }}</h2>
                        </div>
                    </div>

                    @if ($isAdmin)
                        <form method="POST" action="{{ route('admin.qms-teams.secretariat.store', $team) }}" class="mx-auto mt-6 grid max-w-2xl gap-3 sm:grid-cols-[minmax(0,1fr)_auto]">
                            @csrf
                            <input type="hidden" name="team_id" value="{{ $team->id }}">
                            <select name="user_id" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-[#0f3d68]">
                                <option value="">Select a user</option>
                                @foreach ($availableSecretariatUsers as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} — {{ $user->position?->position_name ?? 'No position' }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#0f3d68] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#0b2f52]">+ Add Secretariat</button>
                        </form>
                    @endif

                    <div class="mt-6 flex flex-wrap justify-center gap-4">
                        @forelse ($team->teamSecretariat as $assignment)
                            @include('admin.qms-teams.partials.person-card', [
                                'assignment' => $assignment,
                                'roleLabel' => $team->roleLabel('Secretariat'),
                                'removeAction' => route('admin.qms-teams.secretariat.destroy', [$team, $assignment]),
                                'isAdmin' => $isAdmin,
                                'avatarUrl' => $avatarUrl($assignment->user->avatar),
                            ])
                        @empty
                            <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-8 text-sm text-slate-500">
                                No team secretariat have been assigned.
                            </div>
                        @endforelse
                    </div>

                    @if ($isAdmin && $availableSecretariatUsers->isEmpty())
                        <p class="mt-4 text-center text-xs text-slate-500">No available users remain for this role.</p>
                    @endif
                </section>
            </div>
        </div>
    </div>
@endsection