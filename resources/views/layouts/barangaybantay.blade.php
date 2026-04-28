<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - BarangayBantay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --brand-dark: #2c3e50;
            --brand-blue: #3498db;
            --brand-gray: #95a5a6;
            --brand-success: #27ae60;
            --brand-warning: #f39c12;
            --brand-danger: #e74c3c;
            --page-bg: #f2f5f9;
            --card-bg: #ffffff;
        }

        body {
            background: var(--page-bg);
            font-family: 'Segoe UI', sans-serif;
            color: var(--brand-dark);
        }

        .navbar,
        .card,
        .status-card {
            border: 0;
            border-radius: 20px;
            box-shadow: 0 18px 50px rgba(44, 62, 80, 0.08);
        }

        .navbar {
            background: #ffffff;
            margin-bottom: 1.5rem;
            padding: 1rem 1.25rem;
        }

        .navbar-brand {
            color: var(--brand-dark);
            font-weight: 800;
            letter-spacing: 0.02em;
            font-size: 1.2rem;
        }

        .navbar-text {
            color: #6c7a89;
            font-size: 0.95rem;
        }

        .page-header {
            padding: 2rem 1rem 1rem;
            background: #ffffff;
            border-radius: 20px;
            margin-bottom: 1.5rem;
            box-shadow: 0 18px 50px rgba(44, 62, 80, 0.06);
        }

        .page-header h1 {
            font-size: clamp(2rem, 2.5vw, 2.5rem);
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .page-header p {
            color: #728093;
            margin-bottom: 0;
        }

        .card {
            background: var(--card-bg);
        }

        .form-control,
        .form-select {
            border-radius: 14px;
            border: 1px solid #e7ebf0;
            padding: 0.9rem 1rem;
            background: #fbfdff;
        }

        label.form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .btn-primary {
            background: var(--brand-blue);
            border: none;
            color: #ffffff;
        }

        .btn-secondary {
            background: #dce2e8;
            border: none;
            color: var(--brand-dark);
        }

        .btn-warning {
            background: var(--brand-warning);
            border: none;
            color: #ffffff;
        }

        .btn-danger {
            background: var(--brand-danger);
            border: none;
            color: #ffffff;
        }

        .alert {
            border-radius: 16px;
        }

        .badge-status {
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 700;
            padding: 0.55rem 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .table thead th {
            border-bottom: 2px solid #eef3f8;
            color: #4b5867;
            font-size: 0.95rem;
            padding-bottom: 1rem;
        }

        .table tbody tr:hover {
            background: rgba(52, 152, 219, 0.05);
        }

        .status-card {
            background: #ffffff;
            padding: 1.3rem;
            height: 100%;
        }

        .status-title {
            font-size: 0.8rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #7c8a9d;
            margin-bottom: 0.75rem;
        }

        .status-value {
            font-size: 2.3rem;
            font-weight: 800;
            color: var(--brand-dark);
        }

        .section-title {
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.03em;
            margin-bottom: 1rem;
        }

        .field-label {
            color: #7c8a9d;
            font-size: 0.95rem;
            margin-bottom: 0.3rem;
        }

        .field-value {
            font-weight: 700;
            color: var(--brand-dark);
        }

        .form-actions .btn {
            min-width: 165px;
        }

        .card-row-gap {
            gap: 1.15rem;
        }

        @media (max-width: 768px) {
            .form-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar shadow-sm">
        <div class="container-fluid justify-content-between align-items-center">
            <div>
                <a class="navbar-brand" href="{{ route('incidents.create') }}">BarangayBantay</a>
                <div class="navbar-text">El Salvador City Barangay Disaster Reporting</div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('incidents.create') }}" class="btn btn-primary btn-sm">Report Incident</a>
                <a href="{{ route('incidents.index') }}" class="btn btn-secondary btn-sm">View Dashboard</a>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
