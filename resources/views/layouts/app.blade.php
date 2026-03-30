<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Gestion Bancaire') - Banque Populaire</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    @stack('styles')
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: #f8f9fa;
            color: #2C1A0E;
            overflow-x: hidden;
        }

        .app-container {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* Menu toggle button for mobile */
        .menu-toggle {
            display: none;
            position: fixed;
            left: 20px;
            top: 15px;
            z-index: 1100;
            background: white;
            border: none;
            font-size: 1.5rem;
            color: #2C1A0E;
            cursor: pointer;
            width: 45px;
            height: 45px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            align-items: center;
            justify-content: center;
        }

        /* Sidebar overlay for mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }

        .sidebar-overlay.active {
            display: block;
        }

        /* Main wrapper - pour décaler le contenu principal */
        .main-wrapper {
            flex: 1;
            width: 100%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Styles pour la page de connexion uniquement */
        .guest-layout {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .menu-toggle {
                display: flex;
            }
            
            .main-wrapper {
                margin-left: 0 !important;
                width: 100% !important;
            }
        }

        /* Pour desktop - quand la sidebar est affichée */
        @media (min-width: 769px) {
            body:not(.guest-page) .main-wrapper {
                margin-left: 280px;
                width: calc(100% - 280px);
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .main-content {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body class="{{ request()->routeIs('login') ? 'guest-page' : '' }}">
    <div class="app-container">
        
        <!-- Menu toggle button for mobile (visible uniquement si connecté) -->
        @if(!request()->routeIs('login'))
            <button class="menu-toggle" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <!-- Sidebar overlay for mobile -->
            <div class="sidebar-overlay" id="sidebarOverlay"></div>
            
            <!-- Sidebar - UNIQUEMENT si pas sur la page de connexion -->
            @include('partials.sidebar')
        @endif
        
        <!-- Main Wrapper -->
        <div class="main-wrapper">
            
            <!-- Header - UNIQUEMENT si pas sur la page de connexion -->
            @if(!request()->routeIs('login'))
                @include('partials.header')
            @endif
            
            <!-- Main Content -->
            <main class="main-content">
                <div class="container-fluid py-4">
                    
                    <!-- Messages de succès -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <!-- Messages d'erreur -->
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <!-- Contenu principal de la page -->
                    @yield('content')
                    
                </div>
            </main>
            
            <!-- Footer - UNIQUEMENT si pas sur la page de connexion -->
            @if(!request()->routeIs('login'))
                @include('partials.footer')
            @endif
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script pour le toggle de la sidebar mobile -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            if (toggleBtn && sidebar && overlay) {
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                    overlay.classList.toggle('active');
                });
                
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>