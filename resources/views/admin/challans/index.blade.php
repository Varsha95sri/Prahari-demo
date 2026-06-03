<x-app-layout>
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-950">My Challans</h1>
                <p class="mt-1 text-sm text-slate-500">Generated challans, paid status aur linked cases.</p>
            </div>
            <a href="{{ route('admin.challans.create') }}" class="inline-flex justify-center rounded-md bg-slate-950 px-4 py-2 text-sm font-semibold text-white">Generate Challan</a>
        </div>
        @if(session('success'))<div class="mb-4 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>@endif
        <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase text-slate-500">
                        <tr>
                            <th class="px-5 py-3">#</th>
                            <th class="px-5 py-3">Challan</th>
                            <th class="px-5 py-3">Case</th>
                            <th class="px-5 py-3">Prahari</th>
                            <th class="px-5 py-3">Amount</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($challans as $challan)
                            <tr>
                                <td class="px-5 py-4 text-slate-600">{{ $challans->firstItem() + $loop->index }}</td>
                                <td class="px-5 py-4 font-semibold text-slate-950">{{ $challan->challan_id }}</td>
                                <td class="px-5 py-4 text-slate-600">{{ $challan->case?->case_id ?? '-' }}</td>
                                <td class="px-5 py-4 text-slate-600">{{ $challan->prahari?->name ?? '-' }}</td>
                                <td class="px-5 py-4 font-semibold text-slate-950">Rs. {{ number_format($challan->amount, 2) }}</td>
                                <td class="px-5 py-4"><span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $challan->status === 'paid' ? 'bg-emerald-100 text-emerald-700' : ($challan->status === 'cancelled' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700') }}">{{ ucfirst($challan->status) }}</span></td>
                                <td class="px-5 py-4">
                                    <div class="flex justify-end gap-3">
                                        @if($challan->status === 'pending')
                                            <form method="POST" action="{{ route('admin.challans.update', $challan) }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="paid">
                                                <button class="font-semibold text-emerald-700" onclick="return confirm('Mark this challan as paid?')">Mark Paid</button>
                                            </form>
                                        @elseif($challan->status === 'paid')
                                            <a class="font-semibold text-emerald-700" href="{{ route('admin.payments.create', ['prahari_id' => $challan->prahari_id]) }}">Withdraw</a>
                                        @endif
                                        <a class="font-semibold text-cyan-700" href="{{ route('admin.challans.show', $challan) }}">View</a>
                                        <a class="font-semibold text-amber-700" href="{{ route('admin.challans.edit', $challan) }}">Edit</a>
                                        <form id="delete-challan-{{ $challan->id }}" method="POST" action="{{ route('admin.challans.destroy', $challan) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="js-delete font-semibold text-rose-700">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-5 py-8 text-center text-slate-500">No challans found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-slate-200 px-5 py-4">{{ $challans->links() }}</div>
        </div>
    </div>

    <!-- Confirm Delete Modal -->
    <div id="confirmModal" class="hidden fixed inset-0 z-50 flex items-center justify-center px-4 py-6">
        <div class="absolute inset-0 bg-black/40"></div>
        <div class="relative w-full max-w-sm rounded-lg bg-white p-6 shadow-lg">
            <h3 class="text-lg font-semibold text-slate-900">Confirm action</h3>
            <p id="confirmMessage" class="mt-2 text-sm text-slate-600">Are you sure you want to continue?</p>
            <div class="mt-4 flex justify-end gap-3">
                <button id="confirmNo" type="button" class="inline-flex justify-center rounded-md border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700">No</button>
                <button id="confirmYes" type="button" class="inline-flex justify-center rounded-md bg-rose-600 px-4 py-2 text-sm font-semibold text-white">Yes, delete</button>
            </div>
        </div>
    </div>

    <script>
        (function(){
            let currentDeleteForm = null;
            document.querySelectorAll('.js-delete').forEach(btn => {
                btn.addEventListener('click', function(){
                    currentDeleteForm = this.closest('form');
                    document.getElementById('confirmMessage').textContent = 'Do you really want to delete this challan?';
                    document.getElementById('confirmModal').classList.remove('hidden');
                });
            });
            document.getElementById('confirmNo').addEventListener('click', function(){
                document.getElementById('confirmModal').classList.add('hidden');
                currentDeleteForm = null;
            });
            document.getElementById('confirmYes').addEventListener('click', function(){
                if(currentDeleteForm) currentDeleteForm.submit();
            });
        })();
    </script>
</x-app-layout>
