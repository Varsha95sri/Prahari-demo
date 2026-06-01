<x-app-layout>
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-4xl">
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div><h1 class="text-2xl font-bold text-slate-950">{{ $challan->challan_id }}</h1><p class="text-sm text-slate-500">Case {{ $challan->case?->case_id ?? '-' }}</p></div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.challans.index') }}" class="inline-flex justify-center rounded-md border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700">Back</a>
                    <a href="{{ route('admin.challans.edit', $challan) }}" class="inline-flex justify-center rounded-md bg-slate-950 px-4 py-2 text-sm font-semibold text-white">Edit</a>
                </div>
            </div>
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <dl class="grid grid-cols-1 gap-5 sm:grid-cols-4">
                    <div><dt class="text-sm text-slate-500">Prahari</dt><dd class="mt-1 font-semibold text-slate-950">{{ $challan->prahari?->name ?? '-' }}</dd></div>
                    <div><dt class="text-sm text-slate-500">Amount</dt><dd class="mt-1 font-semibold text-slate-950">Rs. {{ number_format($challan->amount, 2) }}</dd></div>
                    <div><dt class="text-sm text-slate-500">Status</dt><dd class="mt-1 font-semibold text-slate-950">{{ ucfirst($challan->status) }}</dd></div>
                    <div><dt class="text-sm text-slate-500">Created</dt><dd class="mt-1 font-semibold text-slate-950">{{ $challan->created_at?->format('d M Y') }}</dd></div>
                </dl>
            </div>
        </div>
    </div>
</x-app-layout>
