<x-app-layout>
    <div class="mx-auto max-w-7xl space-y-6 px-0 py-1 sm:px-2 lg:px-0">
        <section class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 bg-slate-950 px-5 py-6 text-white sm:px-6">
                <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wide text-cyan-300">My Account</p>
                        <h1 class="mt-2 text-2xl font-black sm:text-3xl">Account Settings</h1>
                        <p class="mt-2 max-w-2xl text-sm text-slate-300">
                            Update your admin name, email address and password.
                        </p>
                    </div>

                    <a href="{{ route('admin.dashboard') }}" class="inline-flex justify-center rounded-md border border-white/20 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-white/10">
                        Back to Dashboard
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 divide-y divide-slate-200 lg:grid-cols-[340px_minmax(0,1fr)] lg:divide-x lg:divide-y-0">
                <aside class="p-5 sm:p-6">
                    <div class="flex items-center gap-4">
                        <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-lg bg-cyan-500 text-2xl font-black text-slate-950">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="truncate text-lg font-black text-slate-950">{{ $user->name }}</p>
                            <p class="truncate text-sm text-slate-500">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="mt-6 space-y-3 rounded-lg bg-slate-50 p-4">
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-sm font-semibold text-slate-600">Role</span>
                            <span class="text-sm font-black text-slate-950">Administrator</span>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-sm font-semibold text-slate-600">Status</span>
                            <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-black text-emerald-700">Active</span>
                        </div>
                    </div>
                </aside>

                <div class="grid grid-cols-1 gap-6 p-5 sm:p-6 xl:grid-cols-2">
                    <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
