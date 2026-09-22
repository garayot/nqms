@extends('layouts.guest')

@section('content')
    <div class="mx-auto max-w-5xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900">Links</h1>
            <p class="mt-2 text-slate-600">Official DepEd and NQMS-related references for the Schools Division Office of Bislig City.</p>
        </div>

        <div class="space-y-6">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="mb-4 text-lg font-semibold text-[#0f3d68]">Official Government Links</h2>
                <div class="space-y-3 text-sm">
                    <a href="https://www.deped.gov.ph" class="block rounded-lg border border-slate-200 p-3 hover:bg-slate-50">Department of Education</a>
                    <a href="https://www.deped.gov.ph" class="block rounded-lg border border-slate-200 p-3 hover:bg-slate-50">DepEd Regional Office</a>
                    <a href="https://www.deped.gov.ph" class="block rounded-lg border border-slate-200 p-3 hover:bg-slate-50">Schools Division Office Updates</a>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="mb-4 text-lg font-semibold text-[#0f3d68]">NQMS and Quality Management</h2>
                <div class="space-y-3 text-sm">
                    <a href="https://www.deped.gov.ph" class="block rounded-lg border border-slate-200 p-3 hover:bg-slate-50">NQMS Standards and Tools</a>
                    <a href="https://www.deped.gov.ph" class="block rounded-lg border border-slate-200 p-3 hover:bg-slate-50">Document Control and Records</a>
                    <a href="https://www.deped.gov.ph" class="block rounded-lg border border-slate-200 p-3 hover:bg-slate-50">Quality Assurance Resources</a>
                </div>
            </div>
        </div>
    </div>
@endsection
