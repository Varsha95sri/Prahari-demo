<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Case List - {{ config('app.name', 'Prahari') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            color: #ffffff;
            padding: 2rem 1rem;
            box-sizing: border-box;
            position: relative;
            overflow-x: hidden;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        .header-section {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        @media (min-width: 1024px) {
            .header-section {
                flex-direction: row;
                align-items: flex-end;
                justify-content: space-between;
            }
        }
        h1 {
            font-size: 2rem;
            font-weight: 700;
            margin: 0 0 0.25rem 0;
        }
        .subtitle {
            color: #94a3b8;
            font-size: 0.95rem;
            margin: 0;
        }
        .header-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }
        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.875rem;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
            transform: translateY(-1px);
        }
        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.875rem;
            background: rgba(255, 255, 255, 0.05);
            color: #e2e8f0;
            border: 1px solid rgba(255, 255, 255, 0.1);
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
            color: white;
        }
        .btn-accent {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.875rem;
            background: #eac27c;
            color: #1e293b;
            border: none;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn-accent:hover {
            background: #dfb368;
            transform: translateY(-1px);
        }

        .success-alert {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            color: #34d399;
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        /* Glass Card & Table styling */
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            margin-bottom: 2rem;
        }
        .card-header {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        @media (min-width: 768px) {
            .card-header {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
        }
        .entries-info {
            color: #cbd5e1;
            font-size: 0.875rem;
        }
        .search-box {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .search-box span {
            font-size: 0.875rem;
            color: #cbd5e1;
            font-weight: 500;
        }
        .search-input {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 0.5rem 1rem;
            color: white;
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
            outline: none;
            transition: all 0.2s ease;
        }
        .search-input:focus {
            border-color: #3b82f6;
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
            text-align: left;
        }
        th {
            background: rgba(255, 255, 255, 0.02);
            color: #94a3b8;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        td {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            color: #cbd5e1;
        }
        tr.case-row {
            transition: background 0.2s ease;
        }
        tr.case-row:hover {
            background: rgba(255, 255, 255, 0.02);
        }

        .case-id {
            font-weight: 700;
            color: white;
        }

        /* Media Avatar bubble */
        .media-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            border: 2px solid #fbbf24;
            background: rgba(255, 255, 255, 0.05);
            overflow: hidden;
            position: relative;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
            transition: transform 0.2s ease;
            cursor: pointer;
        }
        .media-avatar:hover {
            transform: scale(1.05);
        }
        .media-avatar img,
        .media-avatar video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .media-avatar .play-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            color: white;
            font-size: 8px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            letter-spacing: 0.05em;
        }
        .media-na {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            border: 1px dashed rgba(255, 255, 255, 0.2);
            color: #64748b;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            cursor: pointer;
            border: none;
            outline: none;
            transition: all 0.2s ease;
        }
        .status-badge:hover {
            transform: scale(1.05);
        }
        .status-badge:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        .status-open {
            background: rgba(59, 130, 246, 0.15);
            color: #60a5fa;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }
        .status-in_progress {
            background: rgba(245, 158, 11, 0.15);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }
        .status-closed {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        /* Action button icons */
        .action-group {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
        }
        .btn-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.03);
            color: #cbd5e1;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn-icon:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
            color: white;
        }
        .btn-icon-danger {
            color: #f87171;
            border-color: rgba(248, 113, 113, 0.2);
        }
        .btn-icon-danger:hover {
            background: rgba(248, 113, 113, 0.1);
            border-color: rgba(248, 113, 113, 0.3);
            color: #fca5a5;
        }

        .card-footer {
            padding: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* Modal styling */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 50;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            box-sizing: border-box;
        }
        .modal-backdrop.flex {
            display: flex;
        }
        .modal-content {
            background: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            width: 100%;
            max-width: 700px;
            max-height: 90vh;
            overflow-y: auto;
            padding: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
            position: relative;
            box-sizing: border-box;
            animation: modalSlideIn 0.3s ease-out;
        }
        @keyframes modalSlideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-top: 0;
            margin-bottom: 1.5rem;
            color: white;
        }
        .modal-footer {
            margin-top: 2rem;
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
        }

        /* Style Laravel Pagination to look gorgeous on Glass theme */
        .card-footer nav {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .card-footer nav .flex.justify-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }
        .card-footer nav div:first-child {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }
        @media (min-width: 640px) {
            .card-footer nav div:first-child {
                display: none !important;
            }
        }
        .card-footer nav div:last-child {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            width: 100%;
        }
        @media (min-width: 768px) {
            .card-footer nav div:last-child {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
        }
        .card-footer nav div:last-child > div:first-child {
            color: #94a3b8;
            font-size: 0.875rem;
        }
        .card-footer nav div:last-child > div:last-child {
            display: inline-flex;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .card-footer nav div:last-child a,
        .card-footer nav div:last-child span {
            padding: 0.5rem 0.75rem;
            background: rgba(255, 255, 255, 0.03);
            color: #cbd5e1;
            text-decoration: none;
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            font-size: 0.875rem;
        }
        .card-footer nav div:last-child a:last-child,
        .card-footer nav div:last-child span:last-child {
            border-right: none;
        }
        .card-footer nav div:last-child a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }
        .card-footer nav div:last-child span[aria-current="page"] {
            background: rgba(59, 130, 246, 0.2);
            color: #60a5fa;
            font-weight: 600;
        }

        /* Form styling (included inside modals) */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.25rem;
        }
        @media (min-width: 640px) {
            .form-grid {
                grid-template-columns: 1fr 1fr;
            }
            .col-span-2 {
                grid-column: span 2 / span 2;
            }
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .form-group label {
            font-size: 0.875rem;
            font-weight: 500;
            color: #cbd5e1;
            display: block;
            margin: 0;
        }
        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: white;
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            box-sizing: border-box;
            transition: all 0.2s ease;
        }
        .form-control:focus {
            outline: none;
            border-color: #3b82f6;
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        }
        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1.25rem;
            padding-right: 2.5rem;
        }
        select.form-control option {
            background-color: #1e293b;
            color: white;
        }
        .file-input {
            padding: 0.5rem;
        }
        .help-text {
            font-size: 0.75rem;
            color: #94a3b8;
            margin: 0;
        }
        .error-message {
            color: #ef4444;
            font-size: 0.8rem;
            margin-top: 0.25rem;
            list-style: none;
            padding-left: 0;
        }
        .error-message li {
            list-style-type: none;
        }

        .background-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            z-index: -1;
        }
        .blob-1 { top: -10%; left: -10%; width: 500px; height: 500px; background: rgba(59, 130, 246, 0.15); }
        .blob-2 { bottom: -20%; right: -10%; width: 600px; height: 600px; background: rgba(139, 92, 246, 0.1); }
    </style>
</head>
<body>
    <div class="background-blob blob-1"></div>
    <div class="background-blob blob-2"></div>

    <div class="container">
        <div class="header-section">
            <div>
                <h1>Case List</h1>
                <p class="subtitle">Search, upload media, track status and manage case records.</p>
            </div>

            <div class="header-actions">
                <button id="exportCsv" type="button" class="btn-accent">
                    Export CSV
                </button>
                <button id="openCreate" type="button" class="btn-primary">
                    + Add Case
                </button>
                <a href="{{ route('admin.dashboard') }}" class="btn-secondary">
                    Back to Dashboard
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="success-alert">{{ session('success') }}</div>
        @endif

        <div class="glass-card">
            <div class="card-header">
                <div class="entries-info">
                    Showing {{ $cases->firstItem() ?? 0 }} to {{ $cases->lastItem() ?? 0 }} of {{ $cases->total() }} entries
                </div>
                <div class="search-box">
                    <span>Search:</span>
                    <input id="tableSearch" type="search" class="search-input" placeholder="Case, Prahari, location">
                </div>
            </div>

            <div class="table-responsive">
                <table id="casesTable">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Media</th>
                            <th>Case ID</th>
                            <th>Type</th>
                            <th>Prahari</th>
                            <th>Location</th>
                            <th>Challan</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cases as $case)
                            <tr class="case-row">
                                <td>{{ $cases->firstItem() + $loop->index }}</td>
                                <td>
                                    @if($case->document_url)
                                        <a href="{{ $case->document_url }}" target="_blank" class="media-avatar" title="Open media">
                                            @if($case->document_is_image)
                                                <img src="{{ $case->document_url }}" alt="Case media">
                                            @elseif($case->document_is_video)
                                                <video muted playsinline preload="metadata">
                                                    <source src="{{ $case->document_url }}">
                                                </video>
                                                <span class="play-overlay">PLAY</span>
                                            @else
                                                DOC
                                            @endif
                                        </a>
                                    @else
                                        <span class="media-na">NA</span>
                                    @endif
                                </td>
                                <td class="case-id">{{ $case->case_id }}</td>
                                <td>{{ $case->type }}</td>
                                <td>{{ $case->prahari?->name ?? 'Unassigned' }}</td>
                                <td>{{ $case->location }}</td>
                                <td>{{ $case->challans->first()?->challan_id ?? '-' }}</td>
                                <td>
                                    <button type="button" class="js-toggle-status status-badge status-{{ $case->status }}" data-update-url="{{ route('admin.cases.update', $case) }}" data-current-status="{{ $case->status }}">
                                        {{ str_replace('_', ' ', $case->status) }}
                                    </button>
                                </td>
                                <td>{{ $case->created_at?->format('d-m-Y') }}</td>
                                <td>
                                    <div class="action-group">
                                        <a class="btn-icon" href="{{ route('admin.cases.show', $case) }}" title="View">↗</a>
                                        <button type="button" title="Edit case" class="js-edit btn-icon"
                                            data-action="{{ route('admin.cases.update', $case) }}"
                                            data-prahari-id="{{ $case->prahari_id }}"
                                            data-type="{{ $case->type }}"
                                            data-location="{{ $case->location }}"
                                            data-status="{{ $case->status }}"
                                            data-description="{{ e($case->description) }}">✎</button>
                                        <form method="POST" action="{{ route('admin.cases.destroy', $case) }}" style="display:inline-block; margin:0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon btn-icon-danger" onclick="return confirm('Delete this case?')" title="Delete">⌫</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="10" style="text-align: center; padding: 3rem; color: #64748b;">No cases found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer">{{ $cases->links() }}</div>
        </div>
    </div>

    <!-- Create Case Modal -->
    <div id="createModal" class="modal-backdrop">
        <div class="modal-content">
            <h3 class="modal-title">Create Case</h3>
            <form method="POST" action="{{ route('admin.cases.store') }}" enctype="multipart/form-data">
                @csrf
                @include('admin.cases.form', ['case' => null, 'praharis' => $praharis])
                <div class="modal-footer">
                    <button type="button" class="js-close-modal btn-secondary">Cancel</button>
                    <button type="submit" class="btn-primary">Save Case</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Case Modal -->
    <div id="editModal" class="modal-backdrop">
        <div class="modal-content">
            <h3 class="modal-title">Edit Case</h3>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                @include('admin.cases.form', ['case' => $cases->first(), 'praharis' => $praharis])
                <div class="modal-footer">
                    <button type="button" class="js-close-modal btn-secondary">Cancel</button>
                    <button type="submit" class="btn-primary">Save Changes</button>
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

            document.querySelectorAll('.modal-backdrop').forEach((modal) => {
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
</body>
</html>

