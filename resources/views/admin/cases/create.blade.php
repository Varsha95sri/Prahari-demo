<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Case - {{ config('app.name', 'Prahari') }}</title>
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
            max-width: 800px;
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
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
            transform: translateY(-1px);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        
        /* Form grid & control styles */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
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
        label {
            font-size: 0.875rem;
            font-weight: 500;
            color: #cbd5e1;
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
        .form-actions {
            margin-top: 2rem;
            display: flex;
            flex-direction: column-reverse;
            gap: 1rem;
        }
        @media (min-width: 640px) {
            .form-actions {
                flex-direction: row;
                justify-content: flex-end;
            }
        }
        .background-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            z-index: -1;
        }
        .blob-1 { top: -10%; left: -10%; width: 500px; height: 500px; background: rgba(59, 130, 246, 0.2); }
        .blob-2 { bottom: -20%; right: -10%; width: 600px; height: 600px; background: rgba(139, 92, 246, 0.15); }
    </style>
</head>
<body>
    <div class="background-blob blob-1"></div>
    <div class="background-blob blob-2"></div>

    <div class="container">
        <div class="header-section">
            <div>
                <h1>Create Case</h1>
                <p class="subtitle">Create a new case without leaving the dashboard.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn-secondary">Back to Dashboard</a>
        </div>

        <form method="POST" action="{{ route('admin.cases.store') }}" enctype="multipart/form-data" class="glass-card">
            @csrf
            @include('admin.cases.form', ['case' => null])
            <div class="form-actions">
                <a href="{{ route('admin.dashboard') }}" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">Save Case</button>
            </div>
        </form>
    </div>
</body>
</html>

