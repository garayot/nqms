@extends('layouts.guest')

@section('content')
    <div class="mx-auto max-w-xl px-4 py-20 text-center sm:px-6 lg:px-8">
        <div class="rounded-2xl border border-amber-200 bg-white p-10 shadow-sm">
            <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-amber-100 text-3xl">!</div>
            <h1 class="text-3xl font-bold text-slate-900">Account Not Authorized</h1>
            <p class="mt-4 text-slate-600">
                {{ $message ?? 'Your Google account is not authorized to access the NQMS system.' }}
            </p>
            <a href="{{ route('home') }}" class="mt-6 inline-flex rounded-md bg-[#0f3d68] px-5 py-3 text-sm font-semibold text-white">Back to Home</a>
        </div>
    </div>
@endsection
