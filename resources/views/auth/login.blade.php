<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion · Gestion Bancaire Professionnelle</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #d95a43 0%, #d27431 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated background */
        .bg-bubbles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            overflow: hidden;
        }

        .bg-bubbles li {
            position: absolute;
            list-style: none;
            display: block;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.15);
            bottom: -160px;
            animation: square 25s infinite;
            transition-timing-function: linear;
            border-radius: 50%;
        }

        .bg-bubbles li:nth-child(1) {
            left: 10%;
            width: 80px;
            height: 80px;
            animation-delay: 0s;
        }

        .bg-bubbles li:nth-child(2) {
            left: 20%;
            width: 40px;
            height: 40px;
            animation-delay: 2s;
            animation-duration: 17s;
        }

        .bg-bubbles li:nth-child(3) {
            left: 25%;
            width: 120px;
            height: 120px;
            animation-delay: 4s;
        }

        .bg-bubbles li:nth-child(4) {
            left: 40%;
            width: 60px;
            height: 60px;
            animation-delay: 0s;
            animation-duration: 18s;
        }

        .bg-bubbles li:nth-child(5) {
            left: 70%;
            width: 50px;
            height: 50px;
            animation-delay: 0s;
        }

        .bg-bubbles li:nth-child(6) {
            left: 80%;
            width: 110px;
            height: 110px;
            animation-delay: 3s;
        }

        .bg-bubbles li:nth-child(7) {
            left: 32%;
            width: 90px;
            height: 90px;
            animation-delay: 7s;
        }

        .bg-bubbles li:nth-child(8) {
            left: 55%;
            width: 45px;
            height: 45px;
            animation-delay: 15s;
            animation-duration: 40s;
        }

        .bg-bubbles li:nth-child(9) {
            left: 15%;
            width: 35px;
            height: 35px;
            animation-delay: 2s;
            animation-duration: 35s;
        }

        .bg-bubbles li:nth-child(10) {
            left: 90%;
            width: 140px;
            height: 140px;
            animation-delay: 0s;
            animation-duration: 11s;
        }

        @keyframes square {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(-1000px) rotate(720deg);
                opacity: 0;
            }
        }

        /* Main container */
        .login-wrapper {
            width: 100%;
            max-width: 1300px;
            padding: 20px;
            position: relative;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 40px;
            overflow: hidden;
            box-shadow: 0 50px 100px -20px rgba(0, 0, 0, 0.3),
                        0 30px 60px -30px rgba(0, 0, 0, 0.5),
                        inset 0 1px 1px rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            width: 100%;
            animation: slideInUp 1s ease-out;
        }

        /* Left Panel - Branding */
        .brand-panel {
            background: linear-gradient(145deg, #2C1A0E 0%, #4a2a1a 100%);
            padding: 60px 40px;
            color: white;
            display: flex;
            flex-direction: column;
            position: relative;
            isolation: isolate;
        }

        .brand-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 20% 20%, rgba(255,255,255,0.1) 0%, transparent 50%);
            z-index: -1;
        }

        .brand-content {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            flex-direction: column;
            animation: fadeInLeft 1s ease-out;
        }

        /* LOGO DANS CADRE BLANC CENTRÉ */
        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 40px;
        }

        .logo-frame {
            width: 180px;
            height: 180px;
            background: white;
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            animation: pulse 2s infinite;
        }

        .logo-frame img {
            max-width: 140px;
            max-height: 140px;
            width: auto;
            height: auto;
            object-fit: contain;
        }

        .brand-title {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 700;
            font-family: 'Playfair Display', serif;
            line-height: 1.2;
            margin-bottom: 20px;
            text-align: center;
        }

        .brand-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 40px;
            line-height: 1.6;
            text-align: center;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .brand-features {
            margin-top: auto;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            animation: fadeInUp 0.5s ease-out forwards;
            opacity: 0;
            animation-fill-mode: forwards;
        }

        .feature-item:nth-child(1) { animation-delay: 0.2s; }
        .feature-item:nth-child(2) { animation-delay: 0.4s; }
        .feature-item:nth-child(3) { animation-delay: 0.6s; }

        .feature-icon {
            width: 50px;
            height: 50px;
            background: rgba(210, 105, 30, 0.2);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #D2691E;
        }

        .feature-text h4 {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .feature-text p {
            opacity: 0.7;
            font-size: 0.9rem;
        }

        /* Right Panel - Login Form */
        .form-panel {
            padding: 60px 50px;
            background: white;
            display: flex;
            flex-direction: column;
        }

        .form-header {
            margin-bottom: 40px;
            animation: fadeInRight 0.8s ease-out;
        }

        .form-header h2 {
            font-size: 2.2rem;
            font-weight: 600;
            color: #2C1A0E;
            margin-bottom: 10px;
            font-family: 'Playfair Display', serif;
        }

        .form-header p {
            color: #64748b;
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 25px;
            animation: fadeInRight 0.8s ease-out;
            animation-fill-mode: forwards;
            opacity: 0;
        }

        .form-group:nth-child(1) { animation-delay: 0.1s; }
        .form-group:nth-child(2) { animation-delay: 0.2s; }
        .form-group:nth-child(3) { animation-delay: 0.3s; }

        .form-label {
            display: block;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .input-wrapper {
            position: relative;
            transition: all 0.3s;
        }

        .input-wrapper:hover {
            transform: translateY(-2px);
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #D2691E;
            font-size: 1.2rem;
            transition: all 0.3s;
            z-index: 2;
        }

        .form-control {
            width: 100%;
            padding: 16px 16px 16px 52px;
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8fafc;
            position: relative;
            z-index: 1;
        }

        .form-control:focus {
            outline: none;
            border-color: #D2691E;
            background: white;
            box-shadow: 0 0 0 4px rgba(210, 105, 30, 0.1);
            transform: scale(1.02);
        }

        .form-control:focus + .input-icon {
            color: #2C1A0E;
            transform: translateY(-50%) scale(1.1);
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0 30px;
            animation: fadeInRight 0.8s ease-out;
            animation-delay: 0.4s;
            animation-fill-mode: forwards;
            opacity: 0;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            color: #475569;
        }

        .checkbox-wrapper input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #D2691E;
            cursor: pointer;
        }

        .forgot-link {
            color: #D2691E;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }

        .forgot-link:hover {
            color: #2C1A0E;
            transform: translateX(3px);
        }

        .btn-login {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #D2691E, #b85e1a);
            border: none;
            border-radius: 16px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
            margin-bottom: 20px;
            animation: fadeInUp 0.8s ease-out;
            animation-delay: 0.5s;
            animation-fill-mode: forwards;
            opacity: 0;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-login:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 30px -10px rgba(210, 105, 30, 0.5);
        }

        .btn-login i {
            transition: transform 0.3s;
        }

        .btn-login:hover i {
            transform: translateX(5px);
        }

        .demo-credentials {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border-radius: 16px;
            padding: 20px;
            border: 1px solid #e2e8f0;
            animation: fadeInUp 0.8s ease-out;
            animation-delay: 0.6s;
            animation-fill-mode: forwards;
            opacity: 0;
        }

        .demo-title {
            font-weight: 600;
            color: #2C1A0E;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .demo-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            background: white;
            border-radius: 12px;
            margin-bottom: 8px;
            border: 1px solid #e2e8f0;
        }

        .demo-item i {
            color: #D2691E;
        }

        .demo-item span {
            font-family: monospace;
            font-weight: 500;
            color: #2C1A0E;
        }

        .demo-item small {
            color: #64748b;
            margin-left: auto;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            color: #94a3b8;
            font-size: 0.85rem;
            animation: fadeIn 1s ease-out;
            animation-delay: 0.7s;
            animation-fill-mode: forwards;
            opacity: 0;
        }

        .error-message {
            background: #fee2e2;
            border: 1px solid #fecaca;
            border-radius: 16px;
            padding: 16px 20px;
            margin-bottom: 25px;
            color: #991b1b;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: shake 0.5s ease-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        @keyframes slideInUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeInLeft {
            from {
                transform: translateX(-30px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeInRight {
            from {
                transform: translateX(30px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        /* Responsive */
        @media (max-width: 968px) {
            .login-container {
                grid-template-columns: 1fr;
                max-width: 500px;
            }
            
            .brand-panel {
                padding: 40px 30px;
            }
            
            .form-panel {
                padding: 40px 30px;
            }
            
            .logo-frame {
                width: 150px;
                height: 150px;
            }
            
            .logo-frame img {
                max-width: 120px;
                max-height: 120px;
            }
        }

        @media (max-width: 480px) {
            .login-wrapper {
                padding: 10px;
            }
            
            .brand-panel {
                padding: 30px 20px;
            }
            
            .form-panel {
                padding: 30px 20px;
            }
            
            .form-options {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            
            .brand-title {
                font-size: 2rem;
            }
            
            .logo-frame {
                width: 130px;
                height: 130px;
            }
            
            .logo-frame img {
                max-width: 100px;
                max-height: 100px;
            }
        }
    </style>
</head>
<body>
    <!-- Animated background bubbles -->
    <ul class="bg-bubbles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>

    <div class="login-wrapper">
        <div class="login-container">
            <!-- Left Panel - Branding with Logo in White Frame -->
            <div class="brand-panel">
                <div class="brand-content">
                    <!-- LOGO DANS CADRE BLANC CENTRÉ -->
                    <div class="logo-container">
                        <div class="logo-frame">
                            <img src="{{ asset('images/logo.png') }}" alt="Banque Populaire">
                        </div>
                    </div>
                    
                    <div class="brand-title">
                        Gestion Bancaire<br>
                        <span style="font-size: 1.5rem; color: #D2691E;">Professionnelle</span>
                    </div>
                    
                    <div class="brand-subtitle">
                        Plateforme centralisée pour la gestion complète de vos dossiers clients, comptes et opérations bancaires.
                    </div>
                    
                    <div class="brand-features">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <div class="feature-text">
                                <h4>Sécurisé</h4>
                                <p>Authentification renforcée et données chiffrées</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="bi bi-lightning-charge"></i>
                            </div>
                            <div class="feature-text">
                                <h4>Rapide</h4>
                                <p>Traitement instantané des opérations</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="bi bi-graph-up"></i>
                            </div>
                            <div class="feature-text">
                                <h4>Intelligent</h4>
                                <p>Détection automatique des impayés</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Panel - Login Form -->
            <div class="form-panel">
                <div class="form-header">
                    <h2>Bienvenue</h2>
                    <p>Saisissez vos identifiants pour accéder à votre espace</p>
                </div>
                
                @if($errors->any())
                    <div class="error-message">
                        <i class="bi bi-exclamation-circle-fill" style="font-size: 1.2rem;"></i>
                        <span>{{ $errors->first('email') }}</span>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label class="form-label">Adresse e-mail</label>
                        <div class="input-wrapper">
                            <i class="bi bi-envelope-fill input-icon"></i>
                            <input type="email" 
                                   name="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', 'admin@banque.com') }}" 
                                   placeholder="exemple@banque.com"
                                   required 
                                   autofocus>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Mot de passe</label>
                        <div class="input-wrapper">
                            <i class="bi bi-lock-fill input-icon"></i>
                            <input type="password" 
                                   name="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   placeholder="••••••••"
                                   required>
                        </div>
                    </div>
                    
                    <div class="form-options">
                        <label class="checkbox-wrapper">
                            <input type="checkbox" name="remember">
                            <span>Se souvenir de moi</span>
                        </label>
                        
                        @if(Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">
                                <i class="bi bi-question-circle"></i> Mot de passe oublié ?
                            </a>
                        @endif
                    </div>
                    
                    <button type="submit" class="btn-login">
                        <span>Se connecter</span>
                        <i class="bi bi-arrow-right"></i>
                    </button>
                    
                    <div class="demo-credentials">
                        <div class="demo-title">
                            <i class="bi bi-info-circle-fill" style="color: #D2691E;"></i>
                            
                        </div>
                       
                <div class="footer">
                    <i class="bi bi-c-circle me-1"></i> 2026 Gestion Bancaire Professionnelle · Tous droits réservés
                </div>
            </div>
        </div>
    </div>
</body>
</html>