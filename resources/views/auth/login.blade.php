<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom CSS -->
    <style>
        body {
            background: #001d4a;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        .auth-container {
            background: rgba(255, 255, 255, 0.97);
            /* Fondo blanco translúcido */
            border-radius: 15px;
            max-width: 900px;
            overflow: hidden;
            width: 100%;
            display: flex;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        }

        .auth-image {
            flex: 1;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Ajuste perfecto al contenedor */
        }

        .auth-form {
            padding: 50px;
            flex: 1.5;
            background: #ffffff;
            color: #333;
        }

        .auth-form h3 {
            color: #003580;
            font-weight: bold;
        }

        .btn-primary {
            background-color: #003580;
            border-color: #003580;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .form-control {
            border: 2px solid #ddd;
            border-radius: 5px;
            padding: 10px 15px;
        }

        .form-control:focus {
            border-color: #003580;
            box-shadow: 0 0 5px rgba(0, 53, 128, 0.5);
        }

        .auth-footer {
            text-align: center;
            margin-top: 20px;
        }

        .auth-footer a {
            color: #003580;
            font-weight: bold;
            text-decoration: none;
        }

        .auth-footer a:hover {
            color: #0056b3;
        }
    </style>
</head>

<x-auth-session-status class="mb-4" :status="session('status')" />

<body>
    <div class="auth-container">
        <div class="auth-image">
            <!-- Imagen ajustada al tamaño del contenedor -->
            <img src="{{ asset('images/header-image.jpg') }}" alt="Secure Login">
        </div>
        <div class="auth-form">

            <div class="text-center mb-4">
                <h3> ALUVID </h3>
                <p>{{ __('Inicio de sesión') }}</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- User -->
                <div class="mb-4">
                    <label for="email" class="form-label fw-bold">{{ __('Usuario') }}</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                        :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="form-label fw-bold">{{ __('Contraseña') }}</label>
                    <div class="input-group">
                        <input id="password" type="password" class="form-control" name="password"required
                            autocomplete="current-password" />
                        <button class="btn btn-outline-secondary" type="button" id="toggle-password">
                            <i class="bi bi-eye-slash" id="eye-icon"></i>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Submit Button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">{{ __('A C C E D E R') }}</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
<script src="{{ asset('js/admin.js') }}"></script>
