<header class="main-header">
    <div class="header-left">
        <button class="menu-toggle d-md-none" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        
        <!-- LOGO PLUS GRAND (90px) À LA PLACE DU TEXTE -->
        <a href="{{ route('dashboard') }}" class="logo-link">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Banque Populaire" class="logo-img">
        </a>
    </div>
    
    <div class="header-right">
        <!-- Nom de l'utilisateur (taille normale) -->
        <span class="user-name">{{ auth()->user()->nom }}</span>
        
        <!-- Notifications (taille normale) -->
        <div class="dropdown">
            <button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="fas fa-bell"></i>
                @php
                    $notificationsCount = \App\Models\Impaye::where('statut', 'nouveau')->count();
                @endphp
                @if($notificationsCount > 0)
                    <span class="badge bg-danger">{{ $notificationsCount }}</span>
                @endif
            </button>
        </div>
        
        <!-- Avatar (taille normale) -->
        <div class="dropdown">
            <button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <div class="user-avatar">
                    {{ substr(auth()->user()->nom, 0, 1) }}
                </div>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>

<style>
/* BARRE ADAPTÉE POUR LE GRAND LOGO */
.main-header {
    background: white;
    padding: 5px 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    top: 0;
    z-index: 999;
    height: 100px; /* Barre plus haute pour accueillir le logo de 90px */
}

.header-left {
    display: flex;
    align-items: center;
    gap: 15px;
    height: 100%;
}

.menu-toggle {
    display: none;
    background: none;
    border: none;
    font-size: 1.5rem; /* Taille normale */
    color: #2C1A0E;
    cursor: pointer;
}

/* SEUL LE LOGO EST GRAND (90px) */
.logo-link {
    display: flex;
    align-items: center;
    height: 100%;
    text-decoration: none;
}

.logo-img {
    height: 90px;      /* Logo GRAND - 90px */
    width: auto;
    max-width: 280px;
    object-fit: contain;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 15px; /* Gap normal */
    height: 100%;
}

/* TOUT LE RESTE GARDE SA TAILLE NORMALE */
.user-name {
    font-weight: 500;
    color: #2C1A0E;
    font-size: 0.95rem; /* Taille normale */
}

.btn-link {
    color: #2C1A0E;
    position: relative;
    text-decoration: none;
    background: none;
    border: none;
    padding: 0;
    font-size: 1.2rem; /* Taille normale */
    cursor: pointer;
}

.btn-link .badge {
    position: absolute;
    top: -5px;
    right: -5px;
    font-size: 0.6rem; /* Taille normale */
    padding: 2px 5px;
    background-color: #dc3545;
    color: white;
    border-radius: 50%;
}

.user-avatar {
    width: 35px;       /* Taille normale */
    height: 35px;      /* Taille normale */
    border-radius: 50%;
    background-color: #D2691E;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1rem;   /* Taille normale */
    text-transform: uppercase;
}

/* Dropdown menu - taille normale */
.dropdown-menu {
    min-width: 180px;
    margin-top: 10px;
    border: none;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    border-radius: 8px;
}

.dropdown-item {
    padding: 8px 20px;
    font-size: 0.95rem;
}

.dropdown-item i {
    width: 20px;
    text-align: center;
    margin-right: 8px;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
    color: #D2691E;
}

/* Responsive pour mobile - SEUL LE LOGO RESTE GRAND */
@media (max-width: 768px) {
    .main-header {
        padding: 5px 15px;
        height: 90px; /* Barre adaptée sur mobile */
    }
    
    .logo-img {
        height: 80px;  /* Logo encore grand mais légèrement réduit sur mobile */
        max-width: 200px;
    }
    
    .user-name {
        display: none; /* Cache le nom sur mobile */
    }
    
    .menu-toggle {
        display: block;
        font-size: 1.5rem; /* Taille normale */
    }
    
    /* Le reste garde sa taille normale */
    .user-avatar {
        width: 35px;
        height: 35px;
        font-size: 1rem;
    }
    
    .btn-link {
        font-size: 1.2rem;
    }
}

/* Très petits écrans */
@media (max-width: 480px) {
    .main-header {
        height: 85px;
    }
    
    .logo-img {
        height: 75px; /* Logo toujours grand */
        max-width: 160px;
    }
}
</style>

<!-- Script pour le toggle du menu mobile -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('sidebarToggle');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });
    }
});
</script>