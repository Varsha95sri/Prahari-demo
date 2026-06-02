<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Case Details - {{ config('app.name', 'Prahari') }}</title>
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
            max-width: 900px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        .header-section {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        @media (min-width: 640px) {
            .header-section {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
        }
        h1 {
            font-size: 1.875rem;
            font-weight: 700;
            margin: 0 0 0.25rem 0;
        }
        .subtitle {
            color: #94a3b8;
            font-size: 0.9rem;
            margin: 0;
        }
        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
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
        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 0.875rem;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border: none;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
            transform: translateY(-1px);
        }
        .header-actions {
            display: flex;
            gap: 0.75rem;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            margin-bottom: 2rem;
        }
        
        .media-section {
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        .media-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: #94a3b8;
            margin-top: 0;
            margin-bottom: 1rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }
        .media-preview-container {
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            border-radius: 12px;
            max-height: 450px;
            background: #090d16;
        }
        .media-preview-container img,
        .media-preview-container video {
            max-width: 100%;
            max-height: 450px;
            object-fit: contain;
        }
        
        .details-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        @media (min-width: 640px) {
            .details-grid {
                grid-template-columns: repeat(3, 1fr);
            }
            .span-full {
                grid-column: span 3 / span 3;
            }
        }
        
        .detail-item {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.04);
            border-radius: 12px;
            padding: 1rem 1.25rem;
        }
        .detail-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.25rem;
        }
        .detail-value {
            font-size: 1rem;
            font-weight: 600;
            color: #f8fafc;
            margin: 0;
            word-break: break-word;
        }
        .detail-description {
            font-size: 0.95rem;
            line-height: 1.6;
            color: #cbd5e1;
            font-weight: 400;
        }

        /* Status badge styles */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .status-open {
            background: rgba(59, 130, 246, 0.1);
            color: #60a5fa;
            border: 1px solid rgba(59, 130, 246, 0.2);
        }
        .status-in_progress {
            background: rgba(245, 158, 11, 0.1);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.2);
        }
        .status-closed {
            background: rgba(16, 185, 129, 0.1);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.2);
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
                <h1>{{ $case->case_id }}</h1>
                <p class="subtitle">{{ $case->type }} at {{ $case->location }}</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.cases.index') }}" class="btn-secondary">Back</a>
                <a href="{{ route('admin.cases.edit', $case) }}" class="btn-primary">Edit</a>
            </div>
        </div>

        <div class="glass-card">
            @if($case->document_url)
                <div class="media-section">
                    <p class="media-title">Uploaded Case Media</p>
                    <div class="media-preview-container">
                        @if($case->document_is_image)
                            <img src="{{ $case->document_url }}" alt="Case media">
                        @elseif($case->document_is_video)
                            <video controls>
                                <source src="{{ $case->document_url }}">
                            </video>
                        @else
                            <a href="{{ $case->document_url }}" target="_blank" class="btn-primary" style="border-radius: 12px; text-decoration: none;">Open Document</a>
                        @endif
                    </div>
                </div>
            @endif

            <div class="details-grid">
                <div class="detail-item">
                    <div class="detail-label">Prahari</div>
                    <div class="detail-value">{{ $case->prahari?->name ?? 'Unassigned' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Email</div>
                    <div class="detail-value">{{ $case->prahari?->email ?? '-' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Status</div>
                    <div>
                        <span class="status-badge status-{{ $case->status }}">
                            {{ str_replace('_', ' ', $case->status) }}
                        </span>
                    </div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Challan No</div>
                    <div class="detail-value">{{ $case->challans->first()?->challan_id ?? '-' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Created</div>
                    <div class="detail-value">{{ $case->created_at?->format('d M Y') }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Location</div>
                    <div class="detail-value">{{ $case->location }}</div>
                </div>
                <div class="detail-item span-full">
                    <div class="detail-label">Description</div>
                    <div class="detail-value detail-description">{{ $case->description }}</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
