<x-app-layout>
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-950">Prahari Management</h1>
                <p class="mt-1 text-sm text-slate-500">Name, email, phone, password aur status based admin records.</p>
            </div>
            <a href="{{ route('admin.praharis.create') }}" class="inline-flex items-center justify-center rounded-md bg-slate-950 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Add Prahari</a>
        </div>

        @if(session('success'))
            <div class="mb-4 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
        @endif

        <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase text-slate-500">
                        <tr>
                            <th class="px-5 py-3">#</th>
                            <th class="px-5 py-3">Prahari</th>
                            <th class="px-5 py-3">Contact</th>
                            <th class="px-5 py-3">Case</th>
                            <th class="px-5 py-3">Challan</th>
                            <th class="px-5 py-3">Date / Time</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($praharis as $prahari)
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-4 text-slate-600">{{ $praharis->firstItem() + $loop->index }}</td>
                                <td class="px-5 py-4">
                                    <div class="font-semibold text-slate-950">{{ $prahari->name }}</div>
                                    <div class="text-xs text-slate-500">{{ $prahari->prahari_id }}</div>
                                </td>
                                <td class="px-5 py-4 text-slate-600">
                                    <div>{{ $prahari->email }}</div>
                                    <div class="text-xs">{{ $prahari->phone }}</div>
                                </td>
                                <td class="px-5 py-4 text-slate-600">
                                    {{ $prahari->cases->first()?->case_id ?? '-' }}
                                </td>
                                <td class="px-5 py-4 text-slate-600">
                                    {{ $prahari->challans->first()?->challan_id ?? '-' }}
                                </td>
                                <td class="px-5 py-4 text-slate-600">{{ $prahari->created_at?->format('d M Y H:i') }}</td>
                                <td class="px-5 py-4">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $prahari->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">{{ ucfirst($prahari->status) }}</span>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex justify-end gap-3">
                                        <a class="font-semibold text-cyan-700" href="{{ route('admin.praharis.show', $prahari) }}">View</a>
                                        <a class="font-semibold text-amber-700" href="{{ route('admin.praharis.edit', $prahari) }}">Edit</a>
                                        <form method="POST" action="{{ route('admin.praharis.destroy', $prahari) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="font-semibold text-rose-700" onclick="return confirm('Delete this Prahari?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="px-5 py-8 text-center text-slate-500">No Prahari found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-slate-200 px-5 py-4">{{ $praharis->links() }}</div>
        </div>
    </div>
</x-app-layout>
