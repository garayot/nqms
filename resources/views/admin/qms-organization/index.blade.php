@extends('layouts.app')

@section('content')
    @php
        use App\Enums\QmsOrganizationRole;
    @endphp

    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Administration</p>
            <h1 class="mt-2 text-3xl font-bold text-slate-900">QMS Organization Chart</h1>
            <p class="mt-2 text-sm text-slate-600">Manage Top Management (SDS, ASDS), QMR, and QMS Secretaries assignments.</p>
        </div>

        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-bold text-slate-900">Top Management</h2>
            <p class="mt-1 text-sm text-slate-600">SDS and ASDS</p>

            <div class="mt-4 grid gap-4 md:grid-cols-2">
                @foreach ([QmsOrganizationRole::SDS, QmsOrganizationRole::ASDS] as $role)
                    @php
                        $assignment = $membersByRole->get($role->value)?->first();
                    @endphp

                    <article class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <h3 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">{{ $role->label() }}</h3>

                        @if ($assignment)
                            <div class="mt-3 rounded-lg border border-slate-200 bg-white p-3">
                                <p class="font-semibold text-slate-900">{{ $assignment->user->name }}</p>
                                <p class="text-sm text-slate-600">{{ $assignment->user->position?->position_name ?? 'No position assigned' }}</p>
                                <form method="POST" action="{{ route('admin.qms-organization.destroy', $assignment) }}" class="mt-3">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center rounded-md border border-rose-200 px-3 py-1.5 text-xs font-semibold text-rose-700 transition hover:bg-rose-50">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        @else
                            <p class="mt-3 text-sm text-slate-500">No assignment yet.</p>
                        @endif

                        <form method="POST" action="{{ route('admin.qms-organization.store') }}" class="mt-4 space-y-3">
                            @csrf
                            <input type="hidden" name="role" value="{{ $role->value }}">
                            <select name="user_id" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-[#0f3d68]" required>
                                <option value="">Select a user</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} — {{ $user->position?->position_name ?? 'No position' }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="inline-flex items-center justify-center rounded-md bg-[#0f3d68] px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#0b2f52]">
                                Save {{ $role->label() }}
                            </button>
                        </form>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            @php
                $qmr = $membersByRole->get(QmsOrganizationRole::QMR->value)?->first();
            @endphp

            <h2 class="text-xl font-bold text-slate-900">QMR</h2>
            <p class="mt-1 text-sm text-slate-600">Quality Management Representative</p>

            <div class="mt-4 rounded-xl border border-slate-200 bg-slate-50 p-4">
                @if ($qmr)
                    <div class="rounded-lg border border-slate-200 bg-white p-3">
                        <p class="font-semibold text-slate-900">{{ $qmr->user->name }}</p>
                        <p class="text-sm text-slate-600">{{ $qmr->user->position?->position_name ?? 'No position assigned' }}</p>
                        <form method="POST" action="{{ route('admin.qms-organization.destroy', $qmr) }}" class="mt-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center rounded-md border border-rose-200 px-3 py-1.5 text-xs font-semibold text-rose-700 transition hover:bg-rose-50">
                                Remove
                            </button>
                        </form>
                    </div>
                @else
                    <p class="text-sm text-slate-500">No assignment yet.</p>
                @endif

                <form method="POST" action="{{ route('admin.qms-organization.store') }}" class="mt-4 space-y-3">
                    @csrf
                    <input type="hidden" name="role" value="{{ QmsOrganizationRole::QMR->value }}">
                    <select name="user_id" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-[#0f3d68]" required>
                        <option value="">Select a user</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} — {{ $user->position?->position_name ?? 'No position' }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="inline-flex items-center justify-center rounded-md bg-[#0f3d68] px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#0b2f52]">
                        Save QMR
                    </button>
                </form>
            </div>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            @php
                $teamLead = $membersByRole->get(QmsOrganizationRole::SECRETARIAT_TEAM_LEAD->value)?->first();
                $teamMembers = $membersByRole->get(QmsOrganizationRole::SECRETARIAT_TEAM_MEMBER->value) ?? collect();
            @endphp

            <h2 class="text-xl font-bold text-slate-900">QMS Secretaries</h2>
            <p class="mt-1 text-sm text-slate-600">Secretariat Team Lead and Team Members</p>

            <div class="mt-4 grid gap-4 md:grid-cols-2">
                <article class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <h3 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">Team Lead</h3>

                    @if ($teamLead)
                        <div class="mt-3 rounded-lg border border-slate-200 bg-white p-3">
                            <p class="font-semibold text-slate-900">{{ $teamLead->user->name }}</p>
                            <p class="text-sm text-slate-600">{{ $teamLead->user->position?->position_name ?? 'No position assigned' }}</p>
                            <form method="POST" action="{{ route('admin.qms-organization.destroy', $teamLead) }}" class="mt-3">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center rounded-md border border-rose-200 px-3 py-1.5 text-xs font-semibold text-rose-700 transition hover:bg-rose-50">
                                    Remove
                                </button>
                            </form>
                        </div>
                    @else
                        <p class="mt-3 text-sm text-slate-500">No assignment yet.</p>
                    @endif

                    <form method="POST" action="{{ route('admin.qms-organization.store') }}" class="mt-4 space-y-3">
                        @csrf
                        <input type="hidden" name="role" value="{{ QmsOrganizationRole::SECRETARIAT_TEAM_LEAD->value }}">
                        <select name="user_id" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-[#0f3d68]" required>
                            <option value="">Select a user</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} — {{ $user->position?->position_name ?? 'No position' }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="inline-flex items-center justify-center rounded-md bg-[#0f3d68] px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#0b2f52]">
                            Save Team Lead
                        </button>
                    </form>
                </article>

                <article class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <h3 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">Team Members</h3>

                    <div class="mt-3 space-y-3">
                        @forelse ($teamMembers as $assignment)
                            <div class="rounded-lg border border-slate-200 bg-white p-3">
                                <p class="font-semibold text-slate-900">{{ $assignment->user->name }}</p>
                                <p class="text-sm text-slate-600">{{ $assignment->user->position?->position_name ?? 'No position assigned' }}</p>
                                <form method="POST" action="{{ route('admin.qms-organization.destroy', $assignment) }}" class="mt-3">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center rounded-md border border-rose-200 px-3 py-1.5 text-xs font-semibold text-rose-700 transition hover:bg-rose-50">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">No members assigned yet.</p>
                        @endforelse
                    </div>

                    <form method="POST" action="{{ route('admin.qms-organization.store') }}" class="mt-4 space-y-3">
                        @csrf
                        <input type="hidden" name="role" value="{{ QmsOrganizationRole::SECRETARIAT_TEAM_MEMBER->value }}">
                        <select name="user_id" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-[#0f3d68]" required>
                            <option value="">Select a user</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} — {{ $user->position?->position_name ?? 'No position' }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="inline-flex items-center justify-center rounded-md bg-[#0f3d68] px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#0b2f52]">
                            + Add Team Member
                        </button>
                    </form>
                </article>
            </div>
        </section>
    </div>
@endsection
