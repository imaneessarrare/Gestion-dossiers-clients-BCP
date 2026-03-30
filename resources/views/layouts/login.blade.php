<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Gestion Bancaire</title>
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1 class="logo">🏦 Banque</h1>
                <h2>Gestion des Dossiers Clients</h2>
                <p class="text-muted">Connectez-vous à votre espace</p>
            </div>
            
            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf
                
                <div class="mb-3">
                    <label for="login" class="form-label">Identifiant</label>
                    <input type="text" 
                           class="form-control @error('login') is-invalid @enderror" 
                           id="login" 
                           name="login" 
                           value="{{ old('login') }}" 
                           required 
                           autofocus
                           placeholder="Votre identifiant">
                    @error('login')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" 
                           class="form-control @error('login') is-invalid @enderror" 
                           id="password" 
                           name="password" 
                           required
                           placeholder="Votre mot de passe">
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Se souvenir de moi</label>
                </div>
                
                <button type="submit" class="btn btn-primary w-100">
                    Se connecter
                </button>
            </form>
            
            @if($errors->any())
                <div class="alert alert-danger mt-3">
                    {{ $errors->first('login') }}
                </div>
            @endif
        </div>
    </div>
    
    <style>
        .login-page {
            background: linear-gradient(135deg, #2C1A0E 0%, #4a2a1a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            font-family: 'DM Sans', sans-serif;
        }
        
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }
        
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            padding: 40px;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo {
            font-family: 'Playfair Display', serif;
            color: #2C1A0E;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .btn-primary {
            background-color: #D2691E;
            border-color: #D2691E;
            padding: 12px;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            background-color: #b55a1a;
            border-color: #b55a1a;
        }
        
        .form-control:focus {
            border-color: #D2691E;
            box-shadow: 0 0 0 0.2rem rgba(210, 105, 30, 0.25);
        }
    </style>
</body>
</html>