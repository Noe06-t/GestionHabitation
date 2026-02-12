<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Espace Habitant')</title>
    
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
        }
        
        .nav-link:hover {
            color: var(--primary-color);
        }
        
        .btn-logout {
            background: var(--danger-color);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        
        .btn-logout:hover {
            background: #B91C1C;
        }
        
        .container-custom {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .card {
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 1px 3px var(--shadow-color);
            background: white;
            margin-bottom: 30px;
        }
        
        .card-header {
            background: var(--primary-color);
            color: white;
            padding: 1.5rem;
            border: none;
        }
        
        .badge {
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .table th {
            background: var(--primary-color);
            color: white;
            font-weight: 600;
        }
        
        .table-hover tbody tr:hover {
            background: #F3F4F6;
        }
        
        .btn-primary {
            background: var(--primary-color);
            border: none;
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
        }
        
        .btn-success {
            background: var(--success-color);
            border: none;
        }
        
        .btn-success:hover {
            background: #047857;
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('habitant.dashboard') }}">
                <i class="bi bi-person-badge"></i> Espace Habitant
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('habitant.*') ? 'active' : '' }}" href="{{ route('habitant.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Mes Certificats
                        </a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link text-muted">
                            <i class="bi bi-person-circle"></i> {{ Auth::guard('habitant')->user()->prenom }} {{ Auth::guard('habitant')->user()->nom }}
                        </span>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('habitant.logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-logout btn-sm">
                                <i class="bi bi-box-arrow-right"></i> Déconnexion
                            </button>
                        </form>
                    </li>
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
