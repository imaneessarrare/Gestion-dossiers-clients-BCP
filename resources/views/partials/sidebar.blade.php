<aside class="sidebar">
    <div class="sidebar-header">
        <h2>🏦 Banque Populaire</h2>
    </div>
    
    <nav class="sidebar-nav">
        <ul>
            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <i class="fas fa-home"></i>
                    <span>Tableau de bord</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('moyens-paiement.*') ? 'active' : '' }}">
    <a href="{{ route('moyens-paiement.index') }}">
        <i class="fas fa-credit-card"></i>
        <span>Moyens de paiement</span>
    </a>
</li>
            
            <li class="{{ request()->routeIs('clients.*') ? 'active' : '' }}">
                <a href="{{ route('clients.index') }}">
                    <i class="fas fa-users"></i>
                    <span>Clients</span>
                </a>
            </li>
            
            <li class="{{ request()->routeIs('comptes.*') ? 'active' : '' }}">
                <a href="{{ route('comptes.index') }}">
                    <i class="fas fa-credit-card"></i>
                    <span>Comptes</span>
                </a>
            </li>
            
            <li class="{{ request()->routeIs('credits.*') ? 'active' : '' }}">
                <a href="{{ route('credits.index') }}">
                    <i class="fas fa-hand-holding-usd"></i>
                    <span>Crédits</span>
                </a>
            </li>
            
            <li class="{{ request()->routeIs('impayes.*') ? 'active' : '' }}">
                <a href="{{ route('impayes.index') }}">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Impayés</span>
                </a>
            </li>
            
            <li class="{{ request()->routeIs('statistiques') ? 'active' : '' }}">
                <a href="{{ route('statistiques') }}">
                    <i class="fas fa-chart-bar"></i>
                    <span>Statistiques</span>
                </a>
            </li>
            
            @if(auth()->user()->role === 'admin')
            <li class="nav-divider">Administration</li>
            
            <li class="{{ request()->routeIs('utilisateurs.*') ? 'active' : '' }}">
                <a href="#">
                    <i class="fas fa-user-cog"></i>
                    <span>Utilisateurs</span>
                </a>
            </li>
            
            <li class="{{ request()->routeIs('parametres') ? 'active' : '' }}">
                <a href="#">
                    <i class="fas fa-cog"></i>
                    <span>Paramètres</span>
                </a>
            </li>
            @endif
        </ul>
    </nav>
    
    <div class="sidebar-footer">
        <div class="user-info-mini">
            <i class="fas fa-user-circle"></i>
            <span>{{ auth()->user()->nom }}</span>
            <small>({{ auth()->user()->role }})</small>
        </div>
    </div>
</aside>

<style>
.sidebar {
    width: 280px;
    background: linear-gradient(180deg, #2C1A0E 0%, #3a2517 100%);
    color: white;
    display: flex;
    flex-direction: column;
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
}

.sidebar-header {
    padding: 20px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.sidebar-header h2 {
    color: white;
    margin: 0;
    font-size: 1.5rem;
}

.sidebar-nav {
    flex: 1;
    overflow-y: auto;
    padding: 20px 0;
}

.sidebar-nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar-nav li a {
    display: flex;
    align-items: center;
    padding: 12px 20px;
    color: rgba(255,255,255,0.8);
    text-decoration: none;
    transition: all 0.3s;
    gap: 10px;
}

.sidebar-nav li a i {
    width: 20px;
    text-align: center;
}

.sidebar-nav li:hover a,
.sidebar-nav li.active a {
    background-color: #D2691E;
    color: white;
}

.sidebar-nav .nav-divider {
    padding: 20px 20px 10px;
    color: rgba(255,255,255,0.5);
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.sidebar-footer {
    padding: 20px;
    border-top: 1px solid rgba(255,255,255,0.1);
}

.user-info-mini {
    display: flex;
    align-items: center;
    gap: 10px;
    color: white;
}

.user-info-mini i {
    font-size: 1.2rem;
}

.user-info-mini small {
    color: rgba(255,255,255,0.6);
    margin-left: auto;
}
</style>