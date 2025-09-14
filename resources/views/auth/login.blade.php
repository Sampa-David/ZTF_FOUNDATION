<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Login</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }
        .login-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .login-card {
            background: #fff;
            padding: 2rem 2.5rem;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            width: 100%;
            max-width: 420px;
        }
        .login-card h1 {
            text-align: center;
            font-size: 1.8rem;
            font-weight: bold;
            color: #4f46e5;
            margin-bottom: 0.5rem;
        }
        .login-card p {
            text-align: center;
            font-size: 0.9rem;
            color: #6b7280;
            margin-bottom: 1.5rem;
        }
        input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            outline: none;
            margin-bottom: 1rem;
        }
        input:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2);
        }
        .login-btn {
            width: 100%;
            padding: 0.9rem;
            background: #4f46e5;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .login-btn:hover {
            background: #4338ca;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1>ZTF Foundation Login</h1>
            <p>Connectez-vous à votre compte</p>

            @if(session('success'))
                <div class="alert alert-success">{{session('success')}}</div>
            @endif

            @if ($errors->any())
                <div style="color: red; margin-bottom: 1rem;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf

                <label for="matricule">Matricule</label>
                <input id="matricule" type="text" name="matricule" value="{{ old('matricule') }}" placeholder="CM-HQ-IT-001" required autofocus>

                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>

                <label for="password">Mot de passe</label>
                <input id="password" type="password" name="password" required>

                <button type="submit" class="login-btn">Se connecter</button>
            </form>

            <div class="back-home">
                <a href="{{ route('home') }}" class="home-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Retour à l'accueil
                </a>
            </div>
        </div>
    </div>

    <style>
        .back-home {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }

        .home-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #6b7280;
            text-decoration: none;
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            transition: all 0.3s ease;
        }

        .home-link:hover {
            color: #4f46e5;
            background-color: #f3f4f6;
            transform: translateY(-1px);
        }

        .home-link svg {
            transition: transform 0.3s ease;
        }

        .home-link:hover svg {
            transform: translateX(-3px);
        }
    </style>
</body>
</html>
