<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased bg-gradient-to-br from-slate-100 via-slate-200 to-cyan-100">
        <div class="min-h-screen">
            <div class="mx-auto flex min-h-screen w-full max-w-6xl flex-col justify-center px-4 py-8 sm:px-6 lg:px-8">
                <a href="/" class="mb-6 flex items-center gap-3">
                    <x-application-logo class="h-12 w-12 fill-current text-slate-950" />
                    <div>
                        <p class="text-lg font-bold text-slate-950">Prahari Admin</p>
                        <p class="text-sm text-slate-500">Secure control panel</p>
                    </div>
                </a>

                <div class="grid overflow-hidden rounded-[2rem] border border-slate-200 bg-white/95 shadow-xl backdrop-blur-sm lg:grid-cols-[0.85fr_1.15fr]">
                    <div class="hidden bg-slate-950 p-8 text-white lg:flex lg:flex-col lg:justify-between">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-wide text-cyan-300">Admin Access</p>
                            <h1 class="mt-3 text-3xl font-bold">Manage cases, challans, wallet and payments from one place.</h1>
                        </div>
                        <div class="grid gap-3 text-sm text-slate-300">
                            <div class="rounded-md border border-white/10 p-4">Prahari records with name, email, phone and status.</div>
                            <div class="rounded-md border border-white/10 p-4">Case and challan tracking for admin operations.</div>
                            <div class="rounded-md border border-white/10 p-4">Wallet, transactions and withdrawal approvals.</div>
                        </div>
                    </div>
                    <div class="p-5 sm:p-8">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
