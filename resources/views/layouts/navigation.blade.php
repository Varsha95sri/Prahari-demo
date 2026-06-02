@php
    $items = [
        ['label' => 'Dashboard', 'href' => route('admin.dashboard'), 'match' => 'admin.dashboard', 'icon' => 'DB'],
        ['label' => 'Praharis', 'href' => route('admin.praharis.index'), 'match' => 'admin.praharis.*', 'icon' => 'PR'],
        ['label' => 'Cases', 'href' => route('admin.cases.index'), 'match' => 'admin.cases.*', 'icon' => 'CS'],
        ['label' => 'Challans', 'href' => route('admin.challans.index'), 'match' => 'admin.challans.*', 'icon' => 'CH'],
        ['label' => 'Payments', 'href' => route('admin.payments.index'), 'match' => 'admin.payments.*', 'icon' => 'PY'],
        ['label' => 'Reports', 'href' => route('admin.reports.index'), 'match' => 'admin.reports.*', 'icon' => 'RP'],
        ['label' => 'Settings', 'href' => route('profile.edit'), 'match' => 'profile.*', 'icon' => 'ST'],
    ];
    $user = Auth::user();
@endphp

<div x-data="{ open: false }" @keydown.escape.window="open = false">
    <aside class="fixed inset-y-0 left-0 z-40 hidden w-[300px] bg-slate-950 text-white lg:block">
        <div class="flex h-24 items-center border-b border-white/10 bg-white px-10 text-slate-950">
            <a href="{{ route('admin.dashboard') }}" class="text-2xl font-black uppercase tracking-tight">Prahari Admin</a>
        </div>

        <nav class="space-y-2 py-4">
            @foreach($items as $item)
                @php($active = request()->routeIs($item['match']) || ($item['match'] === 'admin.dashboard' && request()->routeIs('dashboard')))
                <a href="{{ $item['href'] }}" class="flex items-center gap-3 rounded-r-md px-6 py-4 text-base font-semibold transition {{ $active ? 'bg-teal-700 text-white' : 'text-white hover:bg-white/10' }}">
                    <span class="w-7 text-center text-xs font-black">{{ $item['icon'] }}</span>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach

            <form method="POST" action="{{ route('logout') }}" class="pt-2">
                @csrf
                <button type="submit" class="flex w-full items-center gap-3 rounded-r-md px-6 py-4 text-left text-base font-semibold text-white transition hover:bg-white/10">
                    <span class="w-7 text-center text-xs font-black">LO</span>
                    <span>Logout</span>
                </button>
            </form>
        </nav>
    </aside>

    <header class="fixed left-0 right-0 top-0 z-30 h-20 border-b border-slate-200 bg-white lg:left-[300px]">
        <div class="flex h-full items-center justify-between">
            <button type="button" class="ml-4 inline-flex h-11 items-center justify-center rounded-md px-3 text-sm font-black text-slate-900 hover:bg-slate-100 sm:ml-6 lg:hidden" @click="open = true">
                Menu
            </button>
            <div class="hidden pl-6 text-lg font-black text-slate-950 lg:block">Prahari Admin</div>

            <div class="flex h-full min-w-0 items-center gap-3 border-l border-slate-200 px-4 sm:px-6">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border-2 border-slate-950 text-lg font-black">
                    {{ strtoupper(substr($user?->name ?? 'A', 0, 1)) }}
                </div>
                <span class="hidden max-w-[160px] truncate text-base font-semibold text-slate-950 sm:inline">{{ $user?->name ?? 'Admin User' }}</span>
            </div>
        </div>
    </header>

    <div x-cloak x-show="open" class="fixed inset-0 z-50 lg:hidden">
        <div class="absolute inset-0 bg-black/50" @click="open = false"></div>
        <aside x-show="open" x-transition class="absolute inset-y-0 left-0 w-[min(300px,85vw)] bg-slate-950 text-white shadow-2xl">
            <div class="flex h-20 items-center justify-between bg-white px-5 text-slate-950">
                <span class="text-xl font-black uppercase">Prahari Admin</span>
                <button type="button" class="rounded border border-slate-300 px-3 py-2 text-sm font-bold" @click="open = false">Close</button>
            </div>
            <nav class="space-y-2 py-4">
                @foreach($items as $item)
                    @php($active = request()->routeIs($item['match']) || ($item['match'] === 'admin.dashboard' && request()->routeIs('dashboard')))
                    <a href="{{ $item['href'] }}" class="flex items-center gap-3 px-6 py-4 text-base font-semibold {{ $active ? 'bg-teal-700' : 'hover:bg-white/10' }}">
                        <span class="w-7 text-center text-xs font-black">{{ $item['icon'] }}</span>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>
        </aside>
    </div>
</div>
