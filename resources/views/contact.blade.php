<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZTF-FOUNDATION  Contact</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .contact-container {
            max-width: 520px;
            margin: 50px auto;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.10);
            padding: 38px 28px 32px 28px;
            animation: fadeIn 1s;
        }
        .contact-container h1 {
            color: #4f8ef8;
            margin-bottom: 18px;
            font-size: 2em;
            font-weight: 700;
            text-align: center;
        }
        .contact-container form label {
            font-weight: 500;
            margin-bottom: 6px;
            display: block;
        }
        .contact-container input, .contact-container textarea {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ddd;
            margin-bottom: 16px;
            font-size: 1em;
        }
        .contact-container textarea {
            min-height: 90px;
            resize: vertical;
        }
        .btn-contact {
            background: #4f8ef8;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 10px 28px;
            font-size: 1.1em;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.2s;
            display: inline-block;
        }
        .btn-contact:hover {
            background: #2563eb;
            color: #fff;
        }
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-radius: 6px;
            padding: 10px 0;
            margin-bottom: 18px;
            text-align: center;
        }
        .alert-error {
            background: #fee2e2;
            color: #b91c1c;
            border-radius: 6px;
            padding: 10px 0;
            margin-bottom: 18px;
            text-align: center;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px);}
            to { opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>
    <div class="contact-container">
        <h1><i class="fa-solid fa-envelope"></i> Contactez-nous</h1>

        {{-- Affichage des messages de succès --}}
        @if(session('success'))
            <div class="alert-success">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        {{-- Affichage des erreurs de validation --}}
        @if($errors->any())
            <div class="alert-error">
                <i class="fa-solid fa-triangle-exclamation"></i> Merci de corriger les erreurs ci-dessous.
            </div>
        @endif

        <form action="#" method="POST">
            @csrf
            <label for="name">Nom</label>
            <input type="text" id="name" name="name" placeholder="Votre nom" value="{{ old('name') }}" required>
            @error('name')
                <div class="alert-error">{{ $message }}</div>
            @enderror

            <label for="email">Adresse email</label>
            <input type="email" id="email" name="email" placeholder="Votre email" value="{{ old('email') }}" required>
            @error('email')
                <div class="alert-error">{{ $message }}</div>
            @enderror

            <label for="message">Message</label>
            <textarea id="message" name="message" placeholder="Votre message..." required>{{ old('message') }}</textarea>
            @error('message')
                <div class="alert-error">{{ $message }}</div>
            @enderror

            <button type="submit" class="btn-contact">
                <i class="fa-solid fa-paper-plane"></i> Envoyer
            </button>
        </form>
    </div>
</body>
</html>