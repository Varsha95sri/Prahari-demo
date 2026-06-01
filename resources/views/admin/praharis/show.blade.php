<x-app-layout>
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-4xl">
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-950">{{ $prahari->name }}</h1>
                    <p class="text-sm text-slate-500">{{ $prahari->prahari_id }}</p>
                </div>
                <a href="{{ route('admin.praharis.edit', $prahari) }}" class="inline-flex justify-center rounded-md bg-slate-950 px-4 py-2 text-sm font-semibold text-white">Edit</a>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Email</p>
                    <p class="mt-2 font-semibold text-slate-950">{{ $prahari->email }}</p>
                </div>
                <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Phone</p>
                    <p class="mt-2 font-semibold text-slate-950">{{ $prahari->phone }}</p>
                </div>
                <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Status</p>
                    <p class="mt-2 font-semibold text-slate-950">{{ ucfirst($prahari->status) }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
