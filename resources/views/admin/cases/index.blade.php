<x-app-layout>
@php
    $statusClasses = [
        'open' => 'bg-blue-100 text-blue-800',
        'in_progress' => 'bg-amber-100 text-amber-800',
        'closed' => 'bg-emerald-100 text-emerald-800',
    ];
@endphp

<div class="space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-slate-950">Case List</h1>
            <p class="mt-1 text-sm text-slate-500">Search, upload media, track status and manage case records.</p>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <button id="exportCsv" type="button" class="inline-flex justify-center rounded-md bg-[#eac27c] px-5 py-3 text-sm font-bold text-slate-800 shadow-sm hover:bg-[#dfb368]">
                Export CSV
            </button>
            <button id="openCreate" type="button" class="inline-flex justify-center rounded-md bg-[#2b3444] px-5 py-3 text-sm font-bold text-white shadow-sm hover:bg-slate-950">
                + Add Case
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
    @endif

    <div class="rounded-md border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-3 border-b border-slate-200 px-4 py-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="text-sm text-slate-500">
                Showing {{ $cases->firstItem() ?? 0 }} to {{ $cases->lastItem() ?? 0 }} of {{ $cases->total() }} entries
            </div>
            <label class="flex items-center gap-2 text-sm text-slate-700">
                <span>Search:</span>
                <input id="tableSearch" type="search" class="h-10 rounded border-slate-300 text-sm focus:border-amber-500 focus:ring-amber-500" placeholder="Case, Prahari, location">
            </label>
        </div>

        <div class="overflow-x-auto">
            <table id="casesTable" class="min-w-full border-collapse text-sm">
                <thead class="bg-slate-50 text-left text-xs font-bold uppercase text-slate-900">
                    <tr>
                        <th class="whitespace-nowrap px-4 py-3">S.No</th>
                        <th class="whitespace-nowrap px-4 py-3">Media</th>
                        <th class="whitespace-nowrap px-4 py-3">Case ID</th>
                        <th class="whitespace-nowrap px-4 py-3">Type</th>
                        <th class="whitespace-nowrap px-4 py-3">Prahari</th>
                        <th class="whitespace-nowrap px-4 py-3">Location</th>
                        <th class="whitespace-nowrap px-4 py-3">Challan</th>
                        <th class="whitespace-nowrap px-4 py-3">Status</th>
                        <th class="whitespace-nowrap px-4 py-3">Date</th>
                        <th class="whitespace-nowrap px-4 py-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($cases as $case)
                        <tr class="case-row bg-white hover:bg-slate-50">
                            <td class="whitespace-nowrap px-4 py-3 text-slate-700">{{ $cases->firstItem() + $loop->index }}</td>
                            <td class="px-4 py-3">
                                @if($case->document_url)
                                    <a href="{{ $case->document_url }}" target="_blank" class="group relative flex h-11 w-11 items-center justify-center overflow-hidden rounded-full border-2 border-amber-300 bg-slate-100 text-xs font-bold text-slate-700 shadow-sm" title="Open media">
                                        @if($case->document_is_image)
                                            <img src="{{ $case->document_url }}" alt="Case media" class="h-full w-full object-cover">
                                        @elseif($case->document_is_video)
                                            <video class="h-full w-full object-cover" muted playsinline preload="metadata">
                                                <source src="{{ $case->document_url }}">
                                            </video>
                                            <span class="absolute inset-0 flex items-center justify-center bg-black/30 text-[10px] text-white">PLAY</span>
                                        @else
                                            DOC
                                        @endif
                                    </a>
                                @else
                                    <span class="flex h-11 w-11 items-center justify-center rounded-full border border-dashed border-slate-300 bg-slate-50 text-xs font-bold text-slate-400">NA</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 font-semibold text-slate-950">{{ $case->case_id }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-slate-700">{{ $case->type }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-slate-700">{{ $case->prahari?->name ?? 'Unassigned' }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-slate-700">{{ $case->location }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-slate-700">{{ $case->challans->first()?->challan_id ?? '-' }}</td>
                            <td class="whitespace-nowrap px-4 py-3">
                                <button type="button" class="js-toggle-status rounded-full px-3 py-1 text-xs font-bold {{ $statusClasses[$case->status] ?? 'bg-slate-100 text-slate-700' }}" data-update-url="{{ route('admin.cases.update', $case) }}" data-current-status="{{ $case->status }}">
                                    {{ str_replace('_', ' ', ucfirst($case->status)) }}
                                </button>
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 text-slate-700">{{ $case->created_at?->format('d-m-Y') }}</td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-2">
                                    <a class="inline-flex h-9 w-9 items-center justify-center rounded border border-slate-300 text-slate-700 hover:bg-slate-100" href="{{ route('admin.cases.show', $case) }}" title="View">↗</a>
                                    <button type="button" title="Edit case" class="js-edit inline-flex h-9 w-9 items-center justify-center rounded border border-slate-300 text-slate-700 hover:bg-slate-100"
                                        data-action="{{ route('admin.cases.update', $case) }}"
                                        data-prahari-id="{{ $case->prahari_id }}"
                                        data-type="{{ $case->type }}"
                                        data-location="{{ $case->location }}"
                                        data-status="{{ $case->status }}"
                                        data-description="{{ e($case->description) }}">✎</button>
                                    <form method="POST" action="{{ route('admin.cases.destroy', $case) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex h-9 w-9 items-center justify-center rounded border border-slate-300 text-rose-700 hover:bg-rose-50" onclick="return confirm('Delete this case?')" title="Delete">⌫</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="10" class="px-4 py-10 text-center text-slate-500">No cases found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-slate-200 px-4 py-4">{{ $cases->links() }}</div>
    </div>
</div>

<div id="createModal" class="fixed inset-0 z-50 hidden items-center justify-center px-4 py-6">
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative max-h-[90vh] w-full max-w-2xl overflow-y-auto rounded-md bg-white p-6 shadow-2xl">
        <h3 class="text-xl font-bold text-slate-950">Create Case</h3>
        <form method="POST" action="{{ route('admin.cases.store') }}" enctype="multipart/form-data" class="mt-5">
            @csrf
            @include('admin.cases.form', ['case' => null, 'praharis' => $praharis])
            <div class="mt-5 flex justify-end gap-3">
                <button type="button" class="js-close-modal rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700">Cancel</button>
                <button type="submit" class="rounded-md bg-slate-950 px-4 py-2 text-sm font-semibold text-white">Save Case</button>
            </div>
        </form>
    </div>
</div>

<div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center px-4 py-6">
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative max-h-[90vh] w-full max-w-2xl overflow-y-auto rounded-md bg-white p-6 shadow-2xl">
        <h3 class="text-xl font-bold text-slate-950">Edit Case</h3>
        <form id="editForm" method="POST" enctype="multipart/form-data" class="mt-5">
            @csrf
            @method('PATCH')
            @include('admin.cases.form', ['case' => $cases->first(), 'praharis' => $praharis])
            <div class="mt-5 flex justify-end gap-3">
                <button type="button" class="js-close-modal rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700">Cancel</button>
                <button type="submit" class="rounded-md bg-slate-950 px-4 py-2 text-sm font-semibold text-white">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';
        const createModal = document.getElementById('createModal');
        const editModal = document.getElementById('editModal');

        function show(modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function hide(modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        document.getElementById('openCreate')?.addEventListener('click', () => show(createModal));
        document.querySelectorAll('.js-close-modal').forEach((button) => button.addEventListener('click', () => {
            hide(createModal);
            hide(editModal);
        }));

        document.querySelectorAll('.fixed[id$="Modal"]').forEach((modal) => {
            modal.addEventListener('click', (event) => {
                if (event.target === modal) hide(modal);
            });
        });

        document.querySelectorAll('.js-edit').forEach((button) => {
            button.addEventListener('click', () => {
                const form = document.getElementById('editForm');
                form.action = button.dataset.action;
                form.querySelector('[name="prahari_id"]').value = button.dataset.prahariId || '';
                form.querySelector('[name="type"]').value = button.dataset.type || '';
                form.querySelector('[name="location"]').value = button.dataset.location || '';
                form.querySelector('[name="status"]').value = button.dataset.status || 'open';
                form.querySelector('[name="description"]').value = button.dataset.description || '';
                show(editModal);
            });
        });

        document.querySelectorAll('.js-toggle-status').forEach((button) => {
            button.addEventListener('click', async () => {
                const next = button.dataset.currentStatus === 'open' ? 'in_progress' : (button.dataset.currentStatus === 'in_progress' ? 'closed' : 'open');
                const data = new FormData();
                data.append('_token', csrf);
                data.append('_method', 'PATCH');
                data.append('status', next);
                button.disabled = true;
                const response = await fetch(button.dataset.updateUrl, {
                    method: 'POST',
                    body: data,
                    headers: {'X-Requested-With': 'XMLHttpRequest'}
                });
                if (response.ok) window.location.reload();
                else {
                    alert('Status update failed.');
                    button.disabled = false;
                }
            });
        });

        document.getElementById('tableSearch')?.addEventListener('input', (event) => {
            const needle = event.target.value.toLowerCase();
            document.querySelectorAll('.case-row').forEach((row) => {
                row.style.display = row.innerText.toLowerCase().includes(needle) ? '' : 'none';
            });
        });

        document.getElementById('exportCsv')?.addEventListener('click', () => {
            const rows = [...document.querySelectorAll('#casesTable tr')]
                .filter((row) => row.offsetParent !== null)
                .map((row) => [...row.children].slice(0, -1).map((cell) => `"${cell.innerText.replaceAll('"', '""').trim()}"`).join(','));
            const blob = new Blob([rows.join('\n')], {type: 'text/csv'});
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'cases.csv';
            link.click();
            URL.revokeObjectURL(link.href);
        });
    });
</script>
</x-app-layout>
