    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Acceso - Villamotos</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
        <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    </head>

    <body>
        <div class="login-container">
            <div class="login-hero">
                <div class="hero-content">
                    <img src="{{ asset('/images/villamotos4.png') }}" alt="Villamotos Logo" class="logo floating">
                    <h1 class="hero-title">Sistema de Gestión</h1>
                    <p class="hero-subtitle">Accede a la plataforma de administración de créditos y clientes</p>
                    <div class="hero-features">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <span class="material-symbols-rounded">shield</span>
                            </div>
                            <div>
                                <h4>Seguridad garantizada</h4>
                                <p>Tus datos están protegidos con encriptación avanzada</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <span class="material-symbols-rounded">speed</span>
                            </div>
                            <div>
                                <h4>Rendimiento óptimo</h4>
                                <p>Plataforma rápida y eficiente para tu trabajo diario</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <span class="material-symbols-rounded">support_agent</span>
                            </div>
                            <div>
                                <h4>Soporte 24/7</h4>
                                <p>Nuestro equipo está siempre disponible para ayudarte</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="login-form-container">
                <div class="form-header">
                    <h2 class="form-title">Iniciar Sesión</h2>
                    <p class="form-subtitle">Ingresa tus credenciales para acceder al sistema</p>
                </div>

                <form class="login-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <div class="input-group">
                            <span class="material-symbols-rounded input-icon">mail</span>
                            <input type="email" id="email" name="email" class="form-input" value="{{old('email')}}" required placeholder="ejemplo@villamotos.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <span class="material-symbols-rounded input-icon">lock</span>
                            <input type="password" id="password" name="password" class="form-input" placeholder="Ingrese su contraseña" required>
                            <button type="button" class="toggle-password">
                                <span class="material-symbols-rounded">visibility</span>
                            </button>
                        </div>
                    </div>

                    <div class="form-options">
                        <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Recordar sesión</label>
                        </div>
                        <a href="#" class="forgot-password">¿Olvidaste tu contraseña?</a>
                    </div>

                    <button type="submit" class="submit-btn">
                        <span class="material-symbols-rounded" style="vertical-align: middle; margin-right: 8px;">login</span>
                        Acceder
                    </button>

                    <div class="divider">o continuar con</div>

                    <div class="social-login">
                        <button type="button" class="social-btn">
                            <span class="material-symbols-rounded">mail</span>
                        </button>
                        <button type="button" class="social-btn">
                            <span class="material-symbols-rounded">fingerprint</span>
                        </button>
                        <button type="button" class="social-btn">
                            <span class="material-symbols-rounded">badge</span>
                        </button>
                    </div>

                    <p class="register-link">¿No tienes una cuenta? <a href="{{route('register')}}">Regístrate aquí</a></p>
                </form>
            </div>
        </div>
        <script src="{{ asset('js/Auth/login.js') }}"></script>

    </body>
    </html>