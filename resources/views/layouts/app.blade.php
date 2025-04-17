<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <title>App</title>
</head>
<body>

    <header class="header">
        <a href="#" class="header-user">
            <span class="material-symbols-rounded">
                person
            </span>
        </a>
    </header>

    <button class="sidebar-menu-buttom">
        <span class="material-symbols-rounded">
            menu
        </span>
    </button>
    <aside class="sidebar">
        {{-- cabezera del sidebar --}}
        <header class="sidebar-header">
        <a href="#" class="header-logo">
    <img src="{{ asset('images/villamotos4.png') }}" alt="Logo" style="width: 165px; height: 75px;">
</a>

            <button class="sidebar-toggler">
                <span class="material-symbols-rounded">
                    chevron_left
                </span>
            </button>
        </header>

        <nav class="sidebar-nav">

            <ul class="nav-list primay-nav">
                <li class="nav-item">
                    <a href="{{route('Escritorio')}}" class="nav-link">
                        <span class="material-symbols-rounded">
                            computer
                        </span>
                        <span class="nav-label">Escritorio</span>
                    </a>
                    
                    <ul class="dropdown-menu">
                        <li class="nav-item">
                            <a href="#" class="nav-link dropdown-title">Escritorio</a>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{route('Clientes')}}" class="nav-link">
                        <span class="material-symbols-rounded">
                            groups
                        </span>
                        <span class="nav-label">Clientes</span>
                    </a>
                    
                    <ul class="dropdown-menu">
                        <li class="nav-item">
                            <a href="#" class="nav-link dropdown-title">Clientes</a>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="material-symbols-rounded">
                            shopping_cart
                        </span>
                        <span class="nav-label">Ventas</span>
                    </a>

                    <ul class="dropdown-menu">
                        <li class="nav-item">
                            <a href="#" class="nav-link dropdown-title">Ventas</a>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{route('Creditos')}}" class="nav-link">
                        <span class="material-symbols-rounded">
                            description
                        </span>
                        <span class="nav-label">Creditos</span>
                    </a>

                    <ul class="dropdown-menu">
                        <li class="nav-item">
                            <a href="#" class="nav-link dropdown-title">Creditos</a>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="material-symbols-rounded">
                            stacks
                        </span>
                        <span class="nav-label">Reportes</span>
                    </a>

                    <ul class="dropdown-menu">
                        <li class="nav-item">
                            <a href="#" class="nav-link dropdown-title">Reportes</a>
                    </ul>
                </li>
                <li class="nav-item dropdown-container">
                    <a href="#" class="nav-link dropdown-toggler">
                        <span class="material-symbols-rounded">
                            settings
                        </span>
                        <span class="nav-label">Configuracion</span>
                        <span class="dropdown-icon material-symbols-rounded">
                            keyboard_arrow_down
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="nav-item">
                            <a href="#" class="nav-link dropdown-title">Configuracion</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link dropdown-link">General</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link dropdown-link">Usuarios</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link dropdown-link">Marcas y Modelos</a>
                        </li>
                    </ul>
                </li>
            </ul>

            <ul class="nav-list secondary-nav">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="material-symbols-rounded">
                            help
                        </span>
                        <span class="nav-label">Soporte</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="nav-item">
                            <a href="#" class="nav-link dropdown-title">Soporte</a>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="material-symbols-rounded">
                            logout
                        </span>
                        <span class="nav-label">cerrar sesion</span>
                    </a>

                    <ul class="dropdown-menu">
                        <li class="nav-item">
                            <a href="#" class="nav-link dropdown-title">Cerrar sesion</a>
                    </ul>
                </li>

            </ul>
        </nav>

    </aside>

    @yield('content')

    <script src="{{asset('js/sidebar.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>