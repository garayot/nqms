@extends('layouts.guest')

@section('content')
    <section class="relative overflow-hidden bg-[#0f3d68] text-white">
        <div class="ambient-float absolute -left-20 top-10 h-52 w-52 rounded-full bg-teal-300/20 blur-2xl"></div>
        <div class="ambient-float absolute -right-16 bottom-8 h-44 w-44 rounded-full bg-cyan-200/20 blur-2xl" style="animation-delay: 1.2s;"></div>

        <div class="relative mx-auto grid max-w-7xl gap-12 px-4 py-20 sm:px-6 lg:grid-cols-2 lg:px-8">
            <div class="space-y-8">
                <div class="inline-flex items-center rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-sky-100">
                    Schools Division Office of Bislig City
                </div>
                <div>
                    <h1 class="text-4xl font-bold tracking-tight sm:text-5xl">National Quality Management System</h1>
                    <p class="mt-5 max-w-xl text-lg text-sky-100">
                        A secure, centralized platform for managing NQMS document requests, reviews, approval workflows, and approved repository records for DepEd personnel.
                    </p>
                </div>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('forms.index') }}" class="rounded-md border border-white/70 bg-white px-5 py-3 text-sm font-semibold text-[#0f3d68] shadow-sm">View Forms</a>
                    @guest
                        <a href="{{ route('login.google') }}" class="rounded-md border border-white/40 bg-white/5 px-5 py-3 text-sm font-semibold text-white hover:bg-white/10">Login with Google</a>
                    @endguest
                </div>
                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-xl border border-white/10 bg-white/5 p-4">
                        <div class="text-2xl font-bold">DRAF</div>
                        <div class="mt-1 text-sm text-sky-100">Document review and approval workflow</div>
                    </div>
                    <div class="rounded-xl border border-white/10 bg-white/5 p-4">
                        <div class="text-2xl font-bold">Audit</div>
                        <div class="mt-1 text-sm text-sky-100">Transparent activity and status tracking</div>
                    </div>
                    <div class="rounded-xl border border-white/10 bg-white/5 p-4">
                        <div class="text-2xl font-bold">Repo</div>
                        <div class="mt-1 text-sm text-sky-100">Approved forms and templates repository</div>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur-sm">
                <div class="rounded-2xl bg-white p-6 text-slate-800 shadow-xl">
                    <div class="mb-5 border-b border-slate-200 pb-4">
                        <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Quick access</div>
                        <h2 class="mt-2 text-2xl font-bold">Document Repository</h2>
                    </div>
                    <div class="space-y-3 text-sm text-slate-600">
                        <div class="flex items-center justify-between rounded-lg bg-slate-50 p-3">
                            <span>Approved forms and templates</span>
                            <a href="{{ route('forms.index') }}" class="font-semibold text-[#0f3d68]">Open</a>
                        </div>
                        <div class="flex items-center justify-between rounded-lg bg-slate-50 p-3">
                            <span>Important links</span>
                            <a href="{{ route('links') }}" class="font-semibold text-[#0f3d68]">View</a>
                        </div>
                        <div class="flex items-center justify-between rounded-lg bg-slate-50 p-3">
                            <span>Organization</span>
                            <a href="{{ route('organization') }}" class="font-semibold text-[#0f3d68]">Visit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-8 md:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-4 text-sm font-semibold uppercase tracking-[0.2em] text-[#0f3d68]">Quick Links</div>
                <ul class="space-y-3 text-sm text-slate-600">
                    <li><a href="{{ route('forms.index') }}" class="hover:text-[#0f3d68]">Forms and Templates</a></li>
                    <li><a href="{{ route('organization') }}" class="hover:text-[#0f3d68]">Organization Details</a></li>
                    <li><a href="{{ route('links') }}" class="hover:text-[#0f3d68]">Official Links</a></li>
                </ul>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-4 text-sm font-semibold uppercase tracking-[0.2em] text-[#0f3d68]">Important Links</div>
                <ul class="space-y-3 text-sm text-slate-600">
                    <li><a href="https://www.deped.gov.ph" class="hover:text-[#0f3d68]">DepEd Official Website</a></li>
                    <li><a href="https://www.deped.gov.ph" class="hover:text-[#0f3d68]">Department Updates</a></li>
                    <li><a href="https://www.deped.gov.ph" class="hover:text-[#0f3d68]">Citizen Services</a></li>
                </ul>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-4 text-sm font-semibold uppercase tracking-[0.2em] text-[#0f3d68]">System Access</div>
                <p class="text-sm text-slate-600">Login using your official @deped.gov.ph Google account to access document submissions, monitoring, and review functions.</p>
                @guest
                    <a href="{{ route('login.google') }}" class="mt-5 inline-flex rounded-md bg-[#0f3d68] px-4 py-2 text-sm font-semibold text-white">Login with Google</a>
                @endguest
            </div>
        </div>
    </section>
@endsection
