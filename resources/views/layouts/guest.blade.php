<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name') }} - NQMS</title>
        <link rel="icon" href="{{ asset(rawurlencode('Bislig SDO logo.ico')) }}" type="image/x-icon">
        <link rel="shortcut icon" href="{{ asset(rawurlencode('Bislig SDO logo.ico')) }}" type="image/x-icon">
        <link rel="apple-touch-icon" href="{{ asset(rawurlencode('Bislig SDO logo.ico')) }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-100 text-slate-800 antialiased">
        @include('components.navbar')
        <main>
            <div class="mx-auto max-w-7xl px-4 pt-4 sm:px-6 lg:px-8">
                @include('components.alert')

                @guest
                    <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-800">
                        Please <a href="{{ route('login.google') }}" class="font-semibold underline underline-offset-2">log in</a> to view or download repository files.
                    </div>
                @endguest
            </div>

            @yield('content')
        </main>
    </body>
</html>
