<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue - Gestion Habitation</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-color: #2563EB;
            --primary-dark: #1E40AF;
            --primary-light: #DBEAFE;
            --success-color: #059669;
            --background-color: #F8FAFC;
            --text-color: #1E293B;
            --text-muted: #64748B;
            --border-color: #E2E8F0;
        }
        
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: var(--background-color);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        
        .welcome-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            border: 1px solid var(--border-color);
        }
        
        .welcome-header {
            background: var(--primary-color);
            color: white;
            padding: 4rem 3rem;
            text-align: center;
        }
        
        .welcome-header h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .welcome-header p {
            font-size: 1.2rem;
            font-weight: 400;
            opacity: 0.95;
        }
        
        .welcome-body {
            padding: 3rem;
        }
        
        .feature-box {
            text-align: center;
            padding: 2rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }
        
        .feature-box:hover {
            background: var(--primary-light);
            border-color: var(--primary-color);
            transform: translateY(-5px);
        }
        
        .feature-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .feature-title {
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            color: var(--text-color);
        }
        
        .feature-desc {
            color: var(--text-muted);
            font-size: 0.95rem;
        }
        
        .btn-custom {
            background: var(--primary-color);
            border: none;
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-custom:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(37, 99, 235, 0.3);
            color: white;
        }
        
        .btn-outline-custom {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 1rem 2.5rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-block;
            background: white;
        }
        
        .btn-outline-custom:hover {
            background: var(--primary-color);
            color: white;
        }
        
        @media (max-width: 768px) {
            .welcome-header h1 {
                font-size: 2rem;
            }
            
            .welcome-header p {
                font-size: 1rem;
            }
            
            .welcome-body {
                padding: 2rem 1.5rem;
            }
            
            .btn-custom, .btn-outline-custom {
                padding: 0.8rem 2rem;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="welcome-card">
        <div class="welcome-header">
            <div class="mb-3">
                <i class="bi bi-buildings" style="font-size: 5rem;"></i>
            </div>
            <h1>Bienvenue sur Gestion Habitation</h1>
            <p>Gérez efficacement vos habitants et certificats en toute simplicité</p>
        </div>
        
        <div class="welcome-body">
            <div class="row mb-5">
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="feature-title">Gestion des Habitants</div>
                        <div class="feature-desc">Enregistrez et gérez les informations de vos habitants</div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="bi bi-file-earmark-text-fill"></i>
                        </div>
                        <div class="feature-title">Certificats</div>
                        <div class="feature-desc">Créez et suivez les certificats d'habitation</div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div class="feature-title">Sécurisé</div>
                        <div class="feature-desc">Système d'authentification sécurisé</div>
                    </div>
                </div>
            </div>
            
            <div class="text-center">
                @auth
                    <a href="{{ route('habitants.index') }}" class="btn-custom me-3">
                        <i class="bi bi-speedometer2"></i> Accéder au tableau de bord
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-custom me-3">
                        <i class="bi bi-box-arrow-in-right"></i> Se connecter
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-outline-custom">
                            <i class="bi bi-person-plus"></i> S'inscrire
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
