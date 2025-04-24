<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Villamotos</title>

    <!-- Fuentes -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">

    <!-- CSS específico para registro -->
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>

<body>
    <div class="register-container">
        <!-- Hero Section -->
        <div class="register-hero">
            <div class="hero-content">
                <img src="{{ asset('images/villamotos4.png') }}" alt="Villamotos Logo" class="logo floating">
                <h1 class="hero-title">Únete ya!</h1>
                <p class="hero-subtitle">Crea tu cuenta para acceder al sistema de gestión</p>

                <div class="hero-features">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <span class="material-symbols-rounded">badge</span>
                        </div>
                        <div>
                            <h4>Registro sencillo</h4>
                            <p>Solo necesitamos algunos datos básicos</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <span class="material-symbols-rounded">verified_user</span>
                        </div>
                        <div>
                            <h4>Cuenta verificada</h4>
                            <p>Te enviaremos un correo de confirmación</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="register-form-container">
            <div class="form-header">
                <h2 class="form-title">Crear Cuenta</h2>
                <p class="form-subtitle">Completa el formulario para registrarte</p>
            </div>

            @if ($errors->any())
            <div class="error-message">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form class="register-form" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label">Nombre Completo</label>
                    <div class="input-group">
                        <span class="material-symbols-rounded input-icon">person</span>
                        <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" placeholder="Ej: Carlos Martínez" required>
                    </div>
                    @error('name')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <div class="input-group">
                        <span class="material-symbols-rounded input-icon">mail</span>
                        <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" placeholder="ejemplo@villamotos.com" required>
                    </div>
                    @error('email')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

            
                <div class="form-group">
                    <label for="password" class="form-label">Contraseña</label>
                    <div class="input-group">
                        <span class="material-symbols-rounded input-icon">lock</span>
                        <input type="password" id="password" name="password" class="form-input" placeholder="Mínimo 8 caracteres" required>
                        <button type="button" class="toggle-password">
                            <span class="material-symbols-rounded">visibility</span>
                        </button>
                    </div>
                    @error('password')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                    <div class="input-group">
                        <span class="material-symbols-rounded input-icon">lock_reset</span>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="Repite tu contraseña" required>
                    </div>
                    {{-- Laravel no valida automáticamente password_confirmation, lo haces tú en RegisterRequest --}}
                </div>

                <div class="form-group terms-group">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">Acepto los <a href="#" class="terms-link">términos y condiciones</a> y la <a href="#" class="terms-link">política de privacidad</a></label>
                </div>

                <button type="submit" class="submit-btn">
                    <span class="material-symbols-rounded" style="vertical-align: middle; margin-right: 8px;">how_to_reg</span>
                    Registrarse
                </button>

                <p class="login-link">¿Ya tienes una cuenta? <a href="{{route('login')}}" class="login-link">Inicia sesión aquí</a></p>
            </form>
        </div>
    </div>

    <!-- JavaScript específico para registro -->
    <script src="{{ asset('js/auth/register.js') }}"></script>
</body>

</html>