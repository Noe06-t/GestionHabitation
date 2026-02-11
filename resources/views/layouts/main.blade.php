<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Gestion Habitation')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-color: #2563EB;
            --primary-dark: #1E40AF;
            --success-color: #059669;
            --warning-color: #F59E0B;
            --danger-color: #DC2626;
            --background-color: #F8FAFC;
            --text-color: #1E293B;
            --text-muted: #64748B;
            --border-color: #E2E8F0;
            --shadow-color: rgba(0, 0, 0, 0.08);
        }
        
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: var(--background-color);
            min-height: 100vh;
            padding-top: 76px;
            color: var(--text-color);
        }
        
        .navbar {
            background: white;
            box-shadow: 0 1px 3px var(--shadow-color);
            border-bottom: 1px solid var(--border-color);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color);
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--text-color);
            transition: all 0.3s ease;
            position: relative;
            padding: 0.5rem 1rem;
        }
        
        .nav-link:hover {
            color: var(--primary-color);
        }
        
        .nav-link.active {
            color: var(--primary-color);
        }
        
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 3px;
            background: var(--primary-color);
            border-radius: 2px;
        }
        
        .card {
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 1px 3px var(--shadow-color);
            background: white;
            margin-bottom: 30px;
            overflow: hidden;
        }
        
        .card-header {
            background: var(--primary-color);
            color: white;
            border-radius: 0 !important;
            padding: 1.5rem;
            border: none;
        }
        
        .card-header h2, .card-header h3 {
            margin: 0;
            font-weight: 600;
        }
        
        .btn-primary {
            background: var(--primary-color);
            border: none;
            border-radius: 8px;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(37, 99, 235, 0.3);
        }
        
        .btn-success {
            background: var(--success-color);
            border: none;
            border-radius: 8px;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .btn-success:hover {
            background: #047857;
            transform: translateY(-1px);
        }
        
        .btn-warning {
            background: var(--warning-color);
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            color: white;
            transition: all 0.2s ease;
        }
        
        .btn-warning:hover {
            background: #D97706;
            color: white;
            transform: translateY(-1px);
        }
        
        .btn-danger {
            background: var(--danger-color);
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .btn-danger:hover {
            background: #B91C1C;
            transform: translateY(-1px);
        }
        
        .btn-light {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            color: var(--text-color);
            transition: all 0.2s ease;
        }
        
        .btn-light:hover {
            background: var(--background-color);
            border-color: var(--primary-color);
            color: var(--primary-color);
        }
        
        .table {
            border-radius: 8px;
            overflow: hidden;
        }
        
        .table thead {
            background: var(--primary-color);
            color: white;
        }
        
        .table tbody tr {
            transition: all 0.2s ease;
            border-bottom: 1px solid var(--border-color);
        }
        
        .table tbody tr:hover {
            background-color: #EFF6FF;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid var(--border-color);
            padding: 0.7rem;
            transition: all 0.2s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        
        .form-label {
            font-weight: 500;
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }
        
        .alert {
            border-radius: 8px;
            border: 1px solid transparent;
            font-weight: 500;
        }
        
        .alert-success {
            background: #D1FAE5;
            color: #065F46;
            border-color: #6EE7B7;
        }
        
        .container-custom {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .btn-logout {
            background: var(--danger-color);
            border: none;
            color: white;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .btn-logout:hover {
            background: #B91C1C;
            transform: translateY(-1px);
        }
        
        .btn-secondary {
            background: var(--text-muted);
            border: none;
            color: white;
            transition: all 0.2s ease;
        }
        
        .btn-secondary:hover {
            background: #475569;
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <i class="bi bi-buildings"></i> Gestion Habitation
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('habitants.*') ? 'active' : '' }}" href="{{ route('habitants.index') }}">
                                <i class="bi bi-people"></i> Habitants
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('certificats.*') ? 'active' : '' }}" href="{{ route('certificats.index') }}">
                                <i class="bi bi-file-earmark-text"></i> Certificats
                            </a>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link text-muted">
                                <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                            </span>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-logout btn-sm">
                                    <i class="bi bi-box-arrow-right"></i> Déconnexion
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right"></i> Connexion
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="bi bi-person-plus"></i> Inscription
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-custom">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @yield('scripts')
</body>
</html>
