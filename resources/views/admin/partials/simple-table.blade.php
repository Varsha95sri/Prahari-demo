<div class="rounded-lg border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-200 px-5 py-4">
        <h2 class="text-base font-semibold text-slate-950">{{ $title }}</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase text-slate-500">
                <tr>
                    <th class="px-5 py-3">ID</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($items as $item)
                    <tr>
                        <td class="px-5 py-4 font-semibold text-slate-900">{{ $item->{$idField} ?? $item->id }}</td>
                        <td class="px-5 py-4 text-slate-600">{{ str_replace('_', ' ', ucfirst($item->status)) }}</td>
                        <td class="px-5 py-4 text-right">
                            <a class="font-semibold text-cyan-700" href="{{ route($routeName, $item) }}">View</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-5 py-6 text-center text-slate-500">No records found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
