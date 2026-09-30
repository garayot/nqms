@extends('layouts.guest')

@section('content')
    <section class="bg-[#0f3d68] text-white">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-sky-100">NQMS Reference</p>
            <h1 class="mt-3 text-4xl font-bold tracking-tight">Quality Policy Statement (QPS)</h1>
            <p class="mt-4 max-w-3xl text-sm text-sky-100 sm:text-base">
                Department of Education - Schools Division Office of Bislig City remains committed to delivering quality basic education through standardized,
                inclusive, and continually improving quality management practices.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid gap-6 lg:grid-cols-3">
            <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">
                <h2 class="text-xl font-semibold text-slate-900">Official Quality Policy Statement</h2>
                <p class="mt-4 text-sm leading-7 text-slate-700">
                    We commit to uphold and sustain an effective National Quality Management System that is aligned with statutory and regulatory requirements,
                    responsive to stakeholders' needs, and anchored on transparency, accountability, and continual improvement in all governance and instructional
                    processes.
                </p>
                <p class="mt-4 text-sm leading-7 text-slate-700">
                    We ensure that quality objectives are clearly communicated, consistently implemented, and regularly reviewed across offices and functional
                    divisions to improve service delivery and learner outcomes.
                </p>

                <div class="mt-6 grid gap-3 sm:grid-cols-2">
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <div class="text-sm font-semibold text-slate-900">Stakeholder Focus</div>
                        <p class="mt-1 text-sm text-slate-600">Deliver timely, relevant, and accessible services to schools, personnel, and partners.</p>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <div class="text-sm font-semibold text-slate-900">Regulatory Compliance</div>
                        <p class="mt-1 text-sm text-slate-600">Comply with legal mandates and quality standards across all documented processes.</p>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <div class="text-sm font-semibold text-slate-900">Process Excellence</div>
                        <p class="mt-1 text-sm text-slate-600">Standardize workflows and strengthen evidence-based planning and execution.</p>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <div class="text-sm font-semibold text-slate-900">Continual Improvement</div>
                        <p class="mt-1 text-sm text-slate-600">Use monitoring results, audits, and feedback to improve system performance.</p>
                    </div>
                </div>
            </article>

            <aside class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900">QPS Quick Notes</h2>
                <ul class="mt-4 space-y-3 text-sm text-slate-700">
                    <li class="rounded-lg border border-slate-200 p-3">Applies to all offices and personnel involved in QMS processes.</li>
                    <li class="rounded-lg border border-slate-200 p-3">Supports customer satisfaction and quality service delivery.</li>
                    <li class="rounded-lg border border-slate-200 p-3">Reviewed periodically as part of management review and planning cycles.</li>
                </ul>
                <a href="{{ route('home') }}" class="mt-5 inline-flex rounded-md bg-[#0f3d68] px-4 py-2 text-sm font-semibold text-white hover:bg-[#0b2f52]">Back to Home</a>
            </aside>
        </div>
    </section>
@endsection
