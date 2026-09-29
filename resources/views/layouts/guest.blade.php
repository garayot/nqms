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
            @yield('content')
        </main>
    </body>
</html>
