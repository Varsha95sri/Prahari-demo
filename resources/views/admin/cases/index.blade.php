<x-app-layout>
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <div class="mb-6 rounded-3xl bg-slate-50 px-6 py-6 shadow-xl relative z-10">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-black text-slate-950">My Cases</h1>
                    <p class="mt-2 max-w-2xl text-sm text-slate-600">Track case reports, email, challan status, and edit records directly from this page.</p>
                </div>
                <button id="openCreate" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 rounded-full bg-white border-2 border-black px-8 py-3 sm:px-10 sm:py-4 text-lg font-bold text-black shadow-2xl transform transition duration-200 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-black/10 ring-offset-2 z-20" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    <span>Create Case</span>
                </button>
            </div>
        </div>
        @if(session('success'))<div class="mb-4 rounded-md border border-emerald-300 bg-emerald-100 px-4 py-3 text-sm font-medium text-emerald-900">{{ session('success') }}</div>@endif
        <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-blue-50 text-left text-xs font-semibold uppercase text-blue-800">
                        <tr>
                            <th class="px-5 py-3">#</th>
                            <th class="px-5 py-3">Case</th>
                            <th class="px-5 py-3">Prahari</th>
                            <th class="px-5 py-3">Email</th>
                            <th class="px-5 py-3">Location</th>
                            <th class="px-5 py-3">Challan</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($cases as $case)
                            <tr class="transition hover:bg-slate-50 odd:bg-white even:bg-slate-50 hover:shadow-sm hover:border-l-4 hover:border-cyan-200">
                                <td class="px-5 py-4 text-slate-700">{{ $cases->firstItem() + $loop->index }}</td>
                                <td class="px-5 py-4"><div class="font-bold text-slate-900 text-lg">{{ $case->case_id }}</div><div class="text-xs text-slate-600">{{ $case->type }}</div></td>
                                <td class="px-5 py-4 text-slate-700">{{ $case->prahari?->name ?? 'Unassigned' }}</td>
                                <td class="px-5 py-4 text-slate-700">{{ $case->prahari?->email ?? '-' }}</td>
                                <td class="px-5 py-4 text-slate-700">{{ $case->location }}</td>
                                <td class="px-5 py-4 text-slate-700">{{ $case->challans->first()?->challan_id ?? '-' }}</td>
                                <td class="px-5 py-4">
                                        @php
                                            $status = $case->status ?? '';
                                            if($status === 'open') {
                                                $badge = 'bg-blue-200 text-blue-900';
                                            } elseif($status === 'in_progress') {
                                                $badge = 'bg-amber-300 text-amber-900';
                                            } elseif($status === 'closed') {
                                                $badge = 'bg-rose-300 text-rose-900';
                                            } else {
                                                $badge = 'bg-slate-300 text-slate-900';
                                            }
                                        @endphp
                                    <button type="button" class="js-toggle-status rounded-full px-3 py-1 text-xs font-semibold {{ $badge }} shadow-sm" data-update-url="{{ route('admin.cases.update', $case) }}" data-current-status="{{ $case->status }}" aria-label="Toggle status">{{ str_replace('_', ' ', ucfirst($case->status)) }}</button>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex justify-end gap-3">
                                        <a class="inline-flex items-center gap-2 rounded-md bg-white border border-slate-200 px-3 py-1 text-sm font-medium text-blue-800 hover:shadow" href="{{ route('admin.cases.show', $case) }}" title="View case details">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-700" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M2 5a2 2 0 012-2h8a2 2 0 012 2v2h-2V5H4v10h6v2H4a2 2 0 01-2-2V5z"/></svg>
                                            <span>View</span>
                                        </a>
                                        <button type="button" title="Edit case" class="js-edit inline-flex items-center gap-2 rounded-md bg-white border border-slate-200 px-3 py-1 text-sm font-medium text-amber-800 hover:shadow" 
                                            data-id="{{ $case->id }}"
                                            data-action="{{ route('admin.cases.update', $case) }}"
                                            data-prahari-id="{{ $case->prahari_id }}"
                                            data-type="{{ $case->type }}"
                                            data-location="{{ $case->location }}"
                                            data-status="{{ $case->status }}"
                                            data-description="{{ htmlentities($case->description) }}"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-700" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M17.414 2.586a2 2 0 010 2.828l-9.9 9.9A1 1 0 016 16H3a1 1 0 01-1-1v-3a1 1 0 01.293-.707l9.9-9.9a2 2 0 012.828 0zM15 4l1 1"/></svg>
                                            <span>Edit</span>
                                        </button>
                                        <form id="delete-case-{{ $case->id }}" method="POST" action="{{ route('admin.cases.destroy', $case) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="js-delete inline-flex items-center gap-2 rounded-md bg-white border border-slate-200 px-3 py-1 text-sm font-medium text-rose-700 hover:shadow">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H3a1 1 0 100 2h14a1 1 0 100-2h-2V3a1 1 0 00-1-1H6zm2 6a1 1 0 012 0v6a1 1 0 11-2 0V8zm4 0a1 1 0 10-2 0v6a1 1 0 102 0V8z" clip-rule="evenodd"/></svg>
                                                <span>Delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="px-5 py-8 text-center text-slate-500">No cases found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-slate-200 px-5 py-4">{{ $cases->links() }}</div>
        </div>
    </div>

    <!-- Create Modal -->
    <div id="createModal" class="fixed inset-0 z-50 hidden items-center justify-center px-4 py-6">
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="relative w-full max-w-2xl rounded-lg bg-white p-6 shadow-2xl ring-1 ring-black/5">
            <h3 class="text-lg font-semibold text-slate-900">Create Case</h3>
            <form id="createForm" method="POST" action="{{ route('admin.cases.store') }}" enctype="multipart/form-data" class="mt-4">
                @csrf
                @include('admin.cases.form', ['case' => null, 'praharis' => $praharis])
                <div class="mt-4 flex justify-end gap-3">
                    <button type="button" id="createCancel" class="inline-flex justify-center rounded-md border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700">Cancel</button>
                    <button type="submit" class="inline-flex justify-center rounded-md bg-slate-950 px-4 py-2 text-sm font-semibold text-white">Save Case</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="hidden fixed inset-0 z-50 items-center justify-center px-4 py-6">
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="relative w-full max-w-2xl rounded-lg bg-white p-6 shadow-2xl ring-1 ring-black/5">
            <h3 class="text-lg font-semibold text-slate-900">Edit Case</h3>
            <form id="editForm" method="POST" class="mt-4 space-y-4">
                @csrf
                @method('PATCH')
                <div class="-mt-3 mb-2">
                    <button type="button" id="editBack" class="inline-flex items-center gap-2 text-sm font-medium text-slate-700 hover:text-slate-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0L4.586 11H17a1 1 0 110 2H4.586l3.707 3.707a1 1 0 01-1.414 1.414l-5.414-5.414a1 1 0 010-1.414l5.414-5.414a1 1 0 011.414 1.414L4.586 9H17a1 1 0 110 2H4.586l3.707 3.707z" clip-rule="evenodd"/></svg>
                        Back
                    </button>
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Prahari</label>
                        <select id="edit_prahari_id" name="prahari_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Select Prahari</option>
                            @foreach($praharis as $prahari)
                                <option value="{{ $prahari->id }}">{{ $prahari->name }} - {{ $prahari->phone }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Case Type</label>
                        <input id="edit_type" name="type" class="mt-1 block w-full rounded-md border-gray-300" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Location</label>
                        <input id="edit_location" name="location" class="mt-1 block w-full rounded-md border-gray-300" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Status</label>
                        <select id="edit_status" name="status" class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="open">Open</option>
                            <option value="in_progress">In Progress</option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Description</label>
                    <textarea id="edit_description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300"></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" id="editCancel" class="inline-flex justify-center rounded-md border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700">Cancel</button>
                    <button type="submit" class="inline-flex justify-center rounded-md bg-slate-950 px-4 py-2 text-sm font-semibold text-white">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Confirm Delete Modal (smaller) -->
    <div id="confirmModal" class="fixed inset-0 z-50 hidden items-center justify-center px-4 py-6">
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="relative w-full max-w-sm rounded-lg bg-white p-6 shadow-2xl ring-1 ring-black/5">
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
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            let currentDeleteForm = null;

            function showModal(modal){
                if(!modal) return;
                // ensure modal displays as flex and is centered
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                modal.setAttribute('aria-hidden','false');
                const inner = modal.querySelector('.relative');
                if(inner){ inner.classList.remove('opacity-0','translate-y-4'); }
            }
            function hideModal(modal){
                if(!modal) return;
                const inner = modal.querySelector('.relative');
                if(inner){ inner.classList.add('opacity-0','translate-y-4'); }
                setTimeout(()=> {
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                    modal.setAttribute('aria-hidden','true');
                }, 180);
            }

            // Delete flow
            document.querySelectorAll('.js-delete').forEach(btn => {
                btn.addEventListener('click', function(){
                    currentDeleteForm = this.closest('form');
                    document.getElementById('confirmMessage').textContent = 'Do you really want to delete this item?';
                    showModal(document.getElementById('confirmModal'));
                });
            });

            document.getElementById('confirmNo').addEventListener('click', function(){
                hideModal(document.getElementById('confirmModal'));
                currentDeleteForm = null;
            });

            document.getElementById('confirmYes').addEventListener('click', function(){
                if(currentDeleteForm) currentDeleteForm.submit();
            });

            // Close modals when clicking outside
            ['createModal','editModal','confirmModal'].forEach(id => {
                const modal = document.getElementById(id);
                if(!modal) return;
                modal.addEventListener('click', function(e){ if(e.target === modal) hideModal(modal); });
                // prepare animation state
                const inner = modal.querySelector('.relative');
                if(inner) inner.classList.add('transition','duration-150','ease-out','opacity-0','translate-y-4');
            });

            // Create modal
            const createModal = document.getElementById('createModal');
            document.getElementById('openCreate').addEventListener('click', function(){ showModal(createModal); });
            document.getElementById('createCancel').addEventListener('click', function(){ hideModal(createModal); });

            // Edit modal
            const editModal = document.getElementById('editModal');
            document.querySelectorAll('.js-edit').forEach(btn => {
                btn.addEventListener('click', function(){
                    const action = this.dataset.action;
                    const form = document.getElementById('editForm');
                    form.action = action;
                    form.querySelector('#edit_prahari_id').value = this.dataset.prahariId || '';
                    form.querySelector('#edit_type').value = this.dataset.type || '';
                    form.querySelector('#edit_location').value = this.dataset.location || '';
                    form.querySelector('#edit_status').value = this.dataset.status || 'open';
                    try{ form.querySelector('#edit_description').value = this.dataset.description || ''; }catch(e){}
                    showModal(editModal);
                });
            });
            document.getElementById('editCancel').addEventListener('click', function(){ hideModal(editModal); });
            const editBackBtn = document.getElementById('editBack');
            if(editBackBtn){ editBackBtn.addEventListener('click', function(){ hideModal(editModal); }); }

            // AJAX submit for create
            const createForm = document.getElementById('createForm');
            if(createForm){
                createForm.addEventListener('submit', async function(e){
                    e.preventDefault();
                    const btn = createForm.querySelector('button[type=submit]');
                    btn.disabled = true; btn.classList.add('opacity-60');
                    const fd = new FormData(createForm);
                    try{
                        const res = await fetch(createForm.action, { method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrf } });
                        if(res.ok){ location.reload(); } else { const text = await res.text(); alert('Error: ' + res.status); btn.disabled=false; btn.classList.remove('opacity-60'); }
                    }catch(err){ alert('Network error'); btn.disabled=false; btn.classList.remove('opacity-60'); }
                });
            }

            // AJAX submit for edit (uses _method=PATCH)
            const editForm = document.getElementById('editForm');
            if(editForm){
                editForm.addEventListener('submit', async function(e){
                    e.preventDefault();
                    const btn = editForm.querySelector('button[type=submit]');
                    btn.disabled = true; btn.classList.add('opacity-60');
                    const fd = new FormData(editForm);
                    fd.append('_method','PATCH');
                    try{
                        const res = await fetch(editForm.action, { method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrf } });
                        if(res.ok){ location.reload(); } else { alert('Failed to save'); btn.disabled=false; btn.classList.remove('opacity-60'); }
                    }catch(err){ alert('Network error'); btn.disabled=false; btn.classList.remove('opacity-60'); }
                });
            }

            // Toggle status by clicking badge
            document.querySelectorAll('.js-toggle-status').forEach(btn => {
                btn.addEventListener('click', async function(){
                    const url = this.dataset.updateUrl; const current = this.dataset.currentStatus || '';
                    const next = current === 'open' ? 'in_progress' : (current === 'in_progress' ? 'closed' : 'open');
                    const fd = new FormData(); fd.append('_method','PATCH'); fd.append('status', next); fd.append('_token', csrf);
                    this.disabled = true;
                    try{
                        const res = await fetch(url, { method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                        if(res.ok) location.reload(); else { alert('Unable to change status'); this.disabled=false; }
                    }catch(e){ alert('Network error'); this.disabled=false; }
                });
            });
        })();
    </script>
</x-app-layout>
