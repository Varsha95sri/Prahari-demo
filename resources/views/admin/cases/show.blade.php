<x-app-layout>
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-4xl">
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-950">{{ $case->case_id }}</h1>
                    <p class="text-sm text-slate-500">{{ $case->type }} at {{ $case->location }}</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.cases.index') }}" class="inline-flex justify-center rounded-md border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700">Back</a>
                    <a href="{{ route('admin.cases.edit', $case) }}" class="inline-flex justify-center rounded-md bg-slate-950 px-4 py-2 text-sm font-semibold text-white">Edit</a>
                </div>
            </div>
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <dl class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                    <div><dt class="text-sm text-slate-500">Prahari</dt><dd class="mt-1 font-semibold text-slate-950">{{ $case->prahari?->name ?? 'Unassigned' }}</dd></div>
                    <div><dt class="text-sm text-slate-500">Email</dt><dd class="mt-1 font-semibold text-slate-950">{{ $case->prahari?->email ?? '-' }}</dd></div>
                    <div><dt class="text-sm text-slate-500">Status</dt><dd class="mt-1 font-semibold text-slate-950">{{ str_replace('_', ' ', ucfirst($case->status)) }}</dd></div>
                    <div><dt class="text-sm text-slate-500">Challan No</dt><dd class="mt-1 font-semibold text-slate-950">{{ $case->challans->first()?->challan_id ?? '-' }}</dd></div>
                    <div><dt class="text-sm text-slate-500">Created</dt><dd class="mt-1 font-semibold text-slate-950">{{ $case->created_at?->format('d M Y') }}</dd></div>
                    <div class="sm:col-span-3"><dt class="text-sm text-slate-500">Description</dt><dd class="mt-1 text-slate-700">{{ $case->description }}</dd></div>
                </dl>
            </div>
        </div>
    </div>
</x-app-layout>
