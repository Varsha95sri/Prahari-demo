<x-app-layout>
<div class="space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-950 sm:text-3xl">Prahari List</h1>
            <p class="mt-1 text-sm font-medium text-slate-600">Manage Prahari ID, Aadhaar, phone, date, media, bank account and status.</p>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <button id="exportCsv" type="button" class="inline-flex justify-center rounded-md bg-amber-500 px-5 py-3 text-sm font-bold text-slate-950 shadow-sm hover:bg-amber-400">
                Export CSV
            </button>
            <a href="{{ route('admin.praharis.create') }}" class="inline-flex justify-center rounded-md bg-teal-700 px-5 py-3 text-sm font-bold text-white shadow-sm hover:bg-teal-800">
                Add Prahari
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-bold text-emerald-800">{{ session('success') }}</div>
    @endif

    <div class="rounded-md border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-3 border-b border-slate-200 px-4 py-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="text-sm font-medium text-slate-600">
                Showing {{ $praharis->firstItem() ?? 0 }} to {{ $praharis->lastItem() ?? 0 }} of {{ $praharis->total() }} entries
            </div>
            <label class="flex flex-col gap-2 text-sm font-semibold text-slate-800 sm:flex-row sm:items-center">
                <span>Search</span>
                <input id="tableSearch" type="search" class="h-10 rounded-md border-slate-300 text-sm text-slate-950 focus:border-teal-600 focus:ring-teal-600">
            </label>
        </div>

        <div class="divide-y divide-slate-200 md:hidden">
            @forelse($praharis as $prahari)
                <article class="prahari-row bg-white p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="break-words text-base font-black text-slate-950">{{ $prahari->name }}</p>
                            <p class="mt-1 text-xs font-semibold text-slate-500">{{ $prahari->prahari_id }}</p>
                        </div>
                        <span class="shrink-0 rounded-full px-3 py-1 text-xs font-bold {{ $prahari->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }}">{{ ucfirst($prahari->status) }}</span>
                    </div>

                    <dl class="mt-4 grid grid-cols-1 gap-3 text-sm">
                        <div>
                            <dt class="font-semibold text-slate-500">Aadhaar</dt>
                            <dd class="mt-1 break-words font-bold text-slate-950">{{ $prahari->aadhaar_number ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-slate-500">Phone</dt>
                            <dd class="mt-1 break-words font-bold text-slate-950">{{ $prahari->phone }}</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-slate-500">Bank Account</dt>
                            <dd class="mt-1 break-words font-bold text-slate-950">{{ $prahari->bank_account ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-slate-500">Date</dt>
                            <dd class="mt-1 font-bold text-slate-950">{{ $prahari->record_date?->format('d-m-Y') ?? $prahari->created_at?->format('d-m-Y') }}</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-slate-500">Media</dt>
                            <dd class="mt-1 font-bold text-slate-950">{{ $prahari->image_path ? 'Image' : 'No image' }} / {{ $prahari->video_path ? 'Video' : 'No video' }}</dd>
                        </div>
                    </dl>

                    <div class="mt-4 flex gap-2">
                        <a href="{{ route('admin.praharis.show', $prahari) }}" class="inline-flex flex-1 justify-center rounded-md border border-slate-300 px-3 py-2 text-sm font-bold text-slate-800 hover:bg-slate-50">View</a>
                        <a href="{{ route('admin.praharis.edit', $prahari) }}" class="inline-flex flex-1 justify-center rounded-md bg-teal-700 px-3 py-2 text-sm font-bold text-white hover:bg-teal-800">Edit</a>
                    </div>
                </article>
            @empty
                <p class="px-4 py-10 text-center text-slate-500">No Prahari found.</p>
            @endforelse
        </div>

        <div class="hidden overflow-x-auto md:block">
            <table id="praharisTable" class="min-w-full border-collapse text-sm">
                <thead class="bg-slate-50 text-left text-xs font-bold uppercase text-slate-900">
                    <tr>
                        <th class="whitespace-nowrap px-4 py-3">S.No</th>
                        <th class="whitespace-nowrap px-4 py-3">Prahari ID</th>
                        <th class="whitespace-nowrap px-4 py-3">Full Name</th>
                        <th class="whitespace-nowrap px-4 py-3">Aadhaar Number</th>
                        <th class="whitespace-nowrap px-4 py-3">Phone Number</th>
                        <th class="whitespace-nowrap px-4 py-3">Bank Account</th>
                        <th class="whitespace-nowrap px-4 py-3">Status</th>
                        <th class="whitespace-nowrap px-4 py-3">Date</th>
                        <th class="whitespace-nowrap px-4 py-3">Media</th>
                        <th class="whitespace-nowrap px-4 py-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($praharis as $prahari)
                        <tr class="prahari-row bg-white hover:bg-slate-50">
                            <td class="whitespace-nowrap px-4 py-3 text-slate-700">{{ $praharis->firstItem() + $loop->index }}</td>
                            <td class="whitespace-nowrap px-4 py-3 font-bold text-slate-950">{{ $prahari->prahari_id }}</td>
                            <td class="whitespace-nowrap px-4 py-3 font-semibold text-slate-900">{{ $prahari->name }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-slate-800">{{ $prahari->aadhaar_number ?? '-' }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-slate-800">{{ $prahari->phone }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-slate-800">{{ $prahari->bank_account ?? '-' }}</td>
                            <td class="whitespace-nowrap px-4 py-3">
                                <span class="rounded-full px-3 py-1 text-xs font-bold {{ $prahari->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }}">{{ ucfirst($prahari->status) }}</span>
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 text-slate-800">{{ $prahari->record_date?->format('d-m-Y') ?? $prahari->created_at?->format('d-m-Y') }}</td>
                            <td class="whitespace-nowrap px-4 py-3">
                                <span class="rounded bg-slate-100 px-2 py-1 text-xs font-bold text-slate-700">{{ $prahari->image_path ? 'Image' : 'No image' }}</span>
                                <span class="rounded bg-slate-100 px-2 py-1 text-xs font-bold text-slate-700">{{ $prahari->video_path ? 'Video' : 'No video' }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.praharis.show', $prahari) }}" class="inline-flex items-center justify-center rounded border border-slate-300 px-3 py-2 text-xs font-bold text-slate-700 hover:bg-slate-100">View</a>
                                    <a href="{{ route('admin.praharis.edit', $prahari) }}" class="inline-flex items-center justify-center rounded border border-slate-300 px-3 py-2 text-xs font-bold text-slate-700 hover:bg-slate-100">Edit</a>
                                    <form method="POST" action="{{ route('admin.praharis.destroy', $prahari) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center rounded border border-slate-300 px-3 py-2 text-xs font-bold text-rose-700 hover:bg-rose-50" onclick="return confirm('Delete this Prahari?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="10" class="px-4 py-10 text-center text-slate-500">No Prahari found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-slate-200 px-4 py-4">{{ $praharis->links() }}</div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('tableSearch')?.addEventListener('input', (event) => {
            const needle = event.target.value.toLowerCase();
            document.querySelectorAll('.prahari-row').forEach((row) => {
                row.style.display = row.innerText.toLowerCase().includes(needle) ? '' : 'none';
            });
        });

        document.getElementById('exportCsv')?.addEventListener('click', () => {
            const rows = [...document.querySelectorAll('#praharisTable tr')]
                .filter((row) => row.offsetParent !== null)
                .map((row) => [...row.children].slice(0, -1).map((cell) => `"${cell.innerText.replaceAll('"', '""').trim()}"`).join(','));
            const blob = new Blob([rows.join('\n')], {type: 'text/csv'});
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'praharis.csv';
            link.click();
            URL.revokeObjectURL(link.href);
        });
    });
</script>
</x-app-layout>
