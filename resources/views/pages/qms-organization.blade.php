@extends('layouts.guest')

@section('content')
    @php
        use App\Enums\QmsOrganizationRole;

        $sds = $membersByRole->get(QmsOrganizationRole::SDS->value)?->first();
        $asds = $membersByRole->get(QmsOrganizationRole::ASDS->value)?->first();
        $qmr = $membersByRole->get(QmsOrganizationRole::QMR->value)?->first();
        $secretariatLead = $membersByRole->get(QmsOrganizationRole::SECRETARIAT_TEAM_LEAD->value)?->first();
        $secretariatMembers = $membersByRole->get(QmsOrganizationRole::SECRETARIAT_TEAM_MEMBER->value) ?? collect();

        $hasAny = $sds || $asds || $qmr || $secretariatLead || $secretariatMembers->isNotEmpty();

        $avatarUrl = function (?string $avatar): ?string {
            if (! filled($avatar)) {
                return null;
            }

            return \Illuminate\Support\Str::startsWith($avatar, ['http://', 'https://'])
                ? $avatar
                : \Illuminate\Support\Facades\Storage::url($avatar);
        };
    @endphp

    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-8 text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">QMS Organization Chart</p>
            <h1 class="mt-2 text-3xl font-bold text-slate-900">QMS Organization</h1>
            <p class="mt-2 text-sm text-slate-600">Top Management, QMR, and QMS Secretaries structure.</p>

            @auth
                @if (auth()->user()?->isAdmin())
                    <a href="{{ route('admin.qms-organization.index') }}" class="mt-4 inline-flex items-center justify-center rounded-md bg-[#0f3d68] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#0b2f52]">
                        Manage QMS Organization
                    </a>
                @endif
            @endauth
        </div>

        @if (! $hasAny)
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center shadow-sm">
                <p class="text-sm text-slate-500">No organization members assigned yet.</p>
            </div>
        @else
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <div class="mx-auto max-w-4xl space-y-6">
                    <section>
                        <h2 class="text-center text-sm font-semibold uppercase tracking-[0.18em] text-slate-500">Top Management</h2>
                        <div class="mx-auto mt-4 flex max-w-md flex-col gap-4">
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-center">
                                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">SDS</p>
                                @if ($sds)
                                    @if ($avatarUrl($sds->user->avatar))
                                        <img src="{{ $avatarUrl($sds->user->avatar) }}" alt="{{ $sds->user->name }} avatar" class="mx-auto mt-3 h-16 w-16 rounded-full object-cover ring-2 ring-slate-200">
                                    @endif
                                    <p class="mt-2 font-bold text-slate-900">{{ $sds->user->name }}</p>
                                    <p class="text-sm text-slate-600">{{ $sds->user->position?->position_name ?? 'No position assigned' }}</p>
                                @else
                                    <p class="mt-2 text-sm text-slate-500">Not assigned</p>
                                @endif
                            </div>

                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-center">
                                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">ASDS</p>
                                @if ($asds)
                                    @if ($avatarUrl($asds->user->avatar))
                                        <img src="{{ $avatarUrl($asds->user->avatar) }}" alt="{{ $asds->user->name }} avatar" class="mx-auto mt-3 h-16 w-16 rounded-full object-cover ring-2 ring-slate-200">
                                    @endif
                                    <p class="mt-2 font-bold text-slate-900">{{ $asds->user->name }}</p>
                                    <p class="text-sm text-slate-600">{{ $asds->user->position?->position_name ?? 'No position assigned' }}</p>
                                @else
                                    <p class="mt-2 text-sm text-slate-500">Not assigned</p>
                                @endif
                            </div>
                        </div>
                    </section>

                    <div class="mx-auto h-8 w-px bg-slate-300"></div>

                    <section class="mx-auto max-w-md rounded-2xl border border-slate-200 bg-slate-50 p-4 text-center">
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">QMR</p>
                        <p class="mt-1 text-xs text-slate-500">Quality Management Representative</p>
                        @if ($qmr)
                            @if ($avatarUrl($qmr->user->avatar))
                                <img src="{{ $avatarUrl($qmr->user->avatar) }}" alt="{{ $qmr->user->name }} avatar" class="mx-auto mt-3 h-16 w-16 rounded-full object-cover ring-2 ring-slate-200">
                            @endif
                            <p class="mt-2 font-bold text-slate-900">{{ $qmr->user->name }}</p>
                            <p class="text-sm text-slate-600">{{ $qmr->user->position?->position_name ?? 'No position assigned' }}</p>
                        @else
                            <p class="mt-2 text-sm text-slate-500">Not assigned</p>
                        @endif
                    </section>

                    <div class="mx-auto h-8 w-px bg-slate-300"></div>

                    <section>
                        <h2 class="text-center text-sm font-semibold uppercase tracking-[0.18em] text-slate-500">QMS Secretaries</h2>

                        <div class="mx-auto mt-4 max-w-md rounded-2xl border border-slate-200 bg-slate-50 p-4 text-center">
                            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Team Lead</p>
                            @if ($secretariatLead)
                                @if ($avatarUrl($secretariatLead->user->avatar))
                                    <img src="{{ $avatarUrl($secretariatLead->user->avatar) }}" alt="{{ $secretariatLead->user->name }} avatar" class="mx-auto mt-3 h-16 w-16 rounded-full object-cover ring-2 ring-slate-200">
                                @endif
                                <p class="mt-2 font-bold text-slate-900">{{ $secretariatLead->user->name }}</p>
                                <p class="text-sm text-slate-600">{{ $secretariatLead->user->position?->position_name ?? 'No position assigned' }}</p>
                            @else
                                <p class="mt-2 text-sm text-slate-500">Not assigned</p>
                            @endif
                        </div>

                        <div class="mx-auto my-6 h-8 w-px bg-slate-300"></div>

                        <div class="flex flex-wrap justify-center gap-4">
                            @forelse ($secretariatMembers as $member)
                                <div class="w-full max-w-sm rounded-2xl border border-slate-200 bg-slate-50 p-4 text-center">
                                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Team Member</p>
                                    @if ($avatarUrl($member->user->avatar))
                                        <img src="{{ $avatarUrl($member->user->avatar) }}" alt="{{ $member->user->name }} avatar" class="mx-auto mt-3 h-16 w-16 rounded-full object-cover ring-2 ring-slate-200">
                                    @endif
                                    <p class="mt-2 font-bold text-slate-900">{{ $member->user->name }}</p>
                                    <p class="text-sm text-slate-600">{{ $member->user->position?->position_name ?? 'No position assigned' }}</p>
                                </div>
                            @empty
                                <div class="w-full rounded-2xl border border-dashed border-slate-300 bg-white p-6 text-center text-sm text-slate-500">
                                    No team members assigned yet.
                                </div>
                            @endforelse
                        </div>
                    </section>
                </div>
            </div>
        @endif
    </div>
@endsection
