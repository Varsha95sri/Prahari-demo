<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Prahari') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 font-sans antialiased">

    <div class="min-h-screen">

        @include('layouts.navigation')

        <main class="lg:ml-72 min-h-screen p-4 lg:p-8">
            {{ $slot }}
        </main>

    </div>

</body>
</html>