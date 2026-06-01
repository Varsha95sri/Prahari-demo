@php
    $adminItems = [
        ['label' => 'Dashboard', 'href' => route('admin.dashboard'), 'match' => 'admin.dashboard'],
        ['label' => 'Prahari', 'href' => route('admin.praharis.index'), 'match' => 'admin.praharis.*'],
        ['label' => 'Cases', 'href' => route('admin.cases.index'), 'match' => 'admin.cases.*'],
        ['label' => 'Challans', 'href' => route('admin.challans.index'), 'match' => 'admin.challans.*'],
        ['label' => 'Payments', 'href' => route('admin.payments.index'), 'match' => 'admin.payments.*'],
        ['label' => 'Reports', 'href' => route('admin.reports.index'), 'match' => 'admin.reports.*'],
        ['label' => 'Settings', 'href' => route('profile.edit'), 'match' => 'profile.*'],
    ];

    $user = Auth::user();
    $initial = $user ? strtoupper(substr($user->name, 0, 1)) : 'A';
@endphp

<div x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false">
    <aside class="fixed inset-y-0 left-0 z-40 hidden w-72 border-r border-slate-200 bg-white lg:flex lg:flex-col">
        <div class="flex h-20 items-center gap-3 border-b border-slate-200 px-6">
            <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-slate-950 text-lg font-black text-white">
                P
            </div>
            <div>
                <p class="text-lg font-black text-slate-950">Prahari Admin</p>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Control Panel</p>
            </div>
        </div>

        <nav class="flex-1 space-y-1 overflow-y-auto px-4 py-5">
            @foreach($adminItems as $item)
                @php
                    $active = request()->routeIs($item['match']) || ($item['match'] === 'admin.dashboard' && request()->routeIs('dashboard'));
                    // Fallback to URL path check in case route names don't match exactly
                    try {
                        $path = parse_url($item['href'], PHP_URL_PATH);
                        $pathPattern = trim($path, '/') . '*';
                        if(!$active && $pathPattern) {
                            $active = request()->is($pathPattern);
                        }
                    } catch(
                        Exception $e) {}
                @endphp
                <a href="{{ $item['href'] }}"
                    class="flex items-center justify-between rounded-lg px-4 py-3 text-sm font-semibold transition {{ $active ? 'bg-slate-950 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-950' }}">
                    <span>{{ $item['label'] }}</span>
                    @if($active)
                        <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                    @endif
                </a>
            @endforeach
        </nav>

        <div class="border-t border-slate-200 p-4">
            <div class="mb-4 flex items-center gap-3 rounded-lg bg-slate-50 p-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-cyan-700 text-sm font-black text-white">
                    {{ $initial }}
                </div>
                <div class="min-w-0">
                    <p class="truncate text-sm font-bold text-slate-950">{{ $user?->name ?? 'Admin' }}</p>
                    <p class="text-xs font-medium text-slate-500">Administrator</p>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-700">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/95 backdrop-blur lg:hidden">
        <div class="flex h-16 items-center justify-between px-4">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-950 text-base font-black text-white">
                    P
                </div>
                <div>
                    <p class="text-base font-black text-slate-950">Prahari Admin</p>
                    <p class="text-xs text-slate-500">Control Panel</p>
                </div>
            </div>

            <button type="button" @click="sidebarOpen = true" class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-bold text-slate-700">
                Menu
            </button>
        </div>
    </header>

    <div x-cloak x-show="sidebarOpen" class="fixed inset-0 z-50 lg:hidden">
        <div x-show="sidebarOpen" x-transition.opacity class="absolute inset-0 bg-slate-950/50" @click="sidebarOpen = false"></div>

        <aside x-show="sidebarOpen" x-transition class="absolute inset-y-0 left-0 flex w-[min(20rem,85vw)] flex-col border-r border-slate-200 bg-white shadow-2xl">
            <div class="flex h-16 items-center justify-between border-b border-slate-200 px-4">
                <p class="text-lg font-black text-slate-950">Admin Menu</p>
                <button type="button" @click="sidebarOpen = false" class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-bold text-slate-700">
                    Close
                </button>
            </div>

            <nav class="flex-1 space-y-1 overflow-y-auto px-4 py-5">
                @foreach($adminItems as $item)
                    @php($active = request()->routeIs($item['match']) || ($item['match'] === 'admin.dashboard' && request()->routeIs('dashboard')))
                    <a href="{{ $item['href'] }}"
                        class="block rounded-lg px-4 py-3 text-sm font-semibold transition {{ $active ? 'bg-slate-950 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-950' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="border-t border-slate-200 p-4">
                <div class="mb-4 flex items-center gap-3 rounded-lg bg-slate-50 p-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-cyan-500 text-sm font-black text-slate-950">
                        {{ $initial }}
                    </div>
                    <div class="min-w-0">
                        <p class="truncate text-sm font-bold text-slate-950">{{ $user?->name ?? 'Admin' }}</p>
                        <p class="text-xs font-medium text-slate-500">Administrator</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full rounded-lg bg-slate-950 px-4 py-2.5 text-sm font-bold text-white">
                        Logout
                    </button>
                </form>
            </div>
        </aside>
    </div>
</div>
