<x-guest-layout>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
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
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.3rem;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            outline: none;
            transition: border 0.3s ease;
        }
        input:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2);
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 1rem 0;
        }
        .checkbox-group label {
            display: flex;
            align-items: center;
            font-size: 0.85rem;
            color: #4b5563;
        }
        .checkbox-group input {
            margin-right: 0.5rem;
        }
        .checkbox-group a {
            font-size: 0.85rem;
            color: #4f46e5;
            text-decoration: none;
        }
        .checkbox-group a:hover {
            text-decoration: underline;
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
        .link-to-register{
            flex-wrap: nowrap;
            color:rgb(77, 77, 251);
            text-align:center;
            align-items: center;
            margin-bottom:-10px
        }
        .link-to-register:hover{
            color:rgb(253, 90, 90);
        }
    </style>

    <div class="login-container">
        <div class="login-card">
            <h1>ZTF Foundation Login</h1>
            <center><h3>Connectez-vous à votre compte</h3></center>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!--  Name -->
                <div>
                    <x-input-label for="matricule" :value="__('Matricule')" />
                    <x-text-input id="matricule" class="block mt-1 w-full" type="text" name="matricule" :value="old('matricule')" placeholder="CM-HQ-nomdepartement-numerosequentiel (ex: CM-HQ-IT-001)" required autofocus />
                    <x-input-error :messages="$errors->get('matricule')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Mot de passe')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ml-3">
                        {{ __('Se connecter') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
