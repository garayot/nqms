@extends('layouts.guest')

@section('content')
    <div class="mx-auto max-w-5xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="mb-8 rounded-2xl bg-[#0f3d68] p-8 text-white shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-sky-100">Schools Division Office</p>
            <h1 class="mt-3 text-3xl font-bold">Bislig City Division</h1>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-xl font-semibold text-[#0f3d68]">Mandate</h2>
                <p class="mt-4 text-sm leading-7 text-slate-600">
                    The Schools Division Office of Bislig City leads the delivery of quality basic education services and ensures the implementation of standards, policies, programs, and support systems aligned with the Department of Education's mission and goals.
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-xl font-semibold text-[#0f3d68]">Core Functions</h2>
                <ul class="mt-4 list-disc space-y-2 pl-5 text-sm leading-7 text-slate-600">
                    <li>Curriculum implementation and supervision</li>
                    <li>School governance and administration</li>
                    <li>Learning continuity and quality improvement</li>
                    <li>Records, document control, and governance systems</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
