<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name') }} - NQMS</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-100 text-slate-800 antialiased">
        @include('components.navbar')
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-6 lg:flex-row">
                @include('components.sidebar')
                <main class="flex-1">
                    @include('components.alert')
                    @yield('content')
                </main>
            </div>
        </div>
    </body>
</html>
