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

    <section class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
        <article class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
            <h2 class="text-center text-xl font-bold text-slate-900">DepEd Quality Policy Statement</h2>
            <p class="mt-2 text-center text-sm font-semibold text-slate-700">(DepEd Order No. 009, s. 2021)</p>

            <p class="mt-8 text-sm leading-7 text-slate-800">
                The Department of Education is committed to provide learners with quality basic education that is accessible, inclusive, and liberating through:
            </p>

            <ul class="mt-4 list-disc space-y-1 pl-6 text-sm font-semibold leading-7 text-slate-900">
                <li>Proactive leadership</li>
                <li>Shared governance</li>
                <li>Evidence-based policies, standards and programs</li>
                <li>Responsive and relevant curricula</li>
                <li>Highly competent and committed officials, teaching and non-teaching personnel</li>
                <li>An enabling environment</li>
            </ul>

            <p class="mt-6 text-sm leading-7 text-slate-800">
                The Department upholds the highest standards of conduct and performance to fulfill stakeholders' needs and expectations by adhering to constitutional mandates,
                statutory, and regulatory requirements, and sustains client satisfaction through continuous improvement of the Quality Management System.
            </p>

            <div class="mt-8">
                <a href="{{ route('home') }}" class="inline-flex rounded-md bg-[#0f3d68] px-4 py-2 text-sm font-semibold text-white hover:bg-[#0b2f52]">Back to Home</a>
            </div>
        </article>
    </section>
@endsection
