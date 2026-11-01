<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'Inicio') | {{ config('carrera.nombre') }}</title>
    <meta name="description" content="@yield('descripcion', 'Portal oficial de la '.config('carrera.nombre').' de la '.config('carrera.universidad'))">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<a class="skip-link" href="#contenido">Saltar al contenido</a>

<div class="topbar py-1">
    <div class="container d-flex flex-wrap justify-content-between gap-2">
        <span class="text-white-50"><i class="bi bi-bank2"></i> {{ config('carrera.universidad') }} · {{ config('carrera.area') }}</span>
        <span class="d-flex gap-3">
            <a href="{{ config('carrera.portal_url') }}" target="_blank" rel="noopener"><i class="bi bi-globe2"></i> Portal UNSXX</a>
            <a href="{{ config('carrera.sia_url') }}" target="_blank" rel="noopener"><i class="bi bi-person-badge"></i> SIA UNSXX</a>
            <a href="{{ config('carrera.moodle_url') }}" target="_blank" rel="noopener"><i class="bi bi-mortarboard"></i> Moodle</a>
        </span>
    </div>
</div>

<nav class="navbar navbar-expand-lg navbar-dark bg-brand sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('inicio') }}">
            <i class="bi bi-heart-pulse-fill fs-3 text-warning"></i>
            <span class="lh-sm"><strong>Kinesiología y Fisioterapia</strong><small class="d-block opacity-75">Universidad Nacional “Siglo XX”</small></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Abrir menú">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menuPrincipal">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('inicio') ? 'active' : '' }}" href="{{ route('inicio') }}">Inicio</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('carrera.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">La carrera</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('carrera.index') }}">Ver todo</a></li>
                        <li><hr class="dropdown-divider"></li>
                        @foreach($menuSecciones ?? [] as $sec)
                            <li><a class="dropdown-item" href="{{ route('carrera.seccion', $sec) }}">{{ $sec->titulo }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('noticias.*') ? 'active' : '' }}" href="{{ route('noticias.index') }}">Noticias</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('documentos.*') ? 'active' : '' }}" href="{{ route('documentos.index') }}">Documentos</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('preinscripcion') ? 'active' : '' }}" href="{{ route('preinscripcion') }}">Preinscripción</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('contacto') ? 'active' : '' }}" href="{{ route('contacto') }}">Contacto</a></li>
            </ul>
            <form class="d-flex me-lg-3 my-2 my-lg-0" role="search" action="{{ route('buscar') }}" method="get">
                <input class="form-control form-control-sm" type="search" name="q" placeholder="Buscar…" aria-label="Buscar" value="{{ request('q') }}">
                <button class="btn btn-sm btn-accent ms-1" type="submit" aria-label="Buscar"><i class="bi bi-search"></i></button>
            </form>
            @auth
                <a class="btn btn-sm btn-outline-light" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Panel</a>
            @else
                <a class="btn btn-sm btn-outline-light" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right"></i> Acceso</a>
            @endauth
        </div>
    </div>
</nav>

<main id="contenido">
    @hasSection('hero')
        @yield('hero')
    @endif
    <div class="container py-4">
        @include('partials.alertas')
        @yield('contenido')
    </div>
</main>

<footer class="footer mt-5 pt-5 pb-3">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-5">
                <h2 class="h5 text-white"><i class="bi bi-heart-pulse-fill text-warning"></i> {{ config('carrera.nombre') }}</h2>
                <p class="small mb-1">{{ config('carrera.universidad') }} · {{ config('carrera.area') }}</p>
                <p class="small"><i class="bi bi-geo-alt"></i> {{ config('carrera.direccion') }}</p>
                @if(config('carrera.correo'))<p class="small mb-1"><i class="bi bi-envelope"></i> {{ config('carrera.correo') }}</p>@endif
                @if(config('carrera.telefono'))<p class="small"><i class="bi bi-telephone"></i> {{ config('carrera.telefono') }}</p>@endif
            </div>
            <div class="col-6 col-md-3">
                <h2 class="h6 text-white">Navegación</h2>
                <ul class="list-unstyled small">
                    <li><a href="{{ route('carrera.index') }}">La carrera</a></li>
                    <li><a href="{{ route('noticias.index') }}">Noticias</a></li>
                    <li><a href="{{ route('documentos.index') }}">Documentos</a></li>
                    <li><a href="{{ route('preinscripcion') }}">Preinscripción</a></li>
                    <li><a href="{{ route('contacto') }}">Contacto</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-4">
                <h2 class="h6 text-white">Enlaces institucionales</h2>
                <ul class="list-unstyled small">
                    <li><a href="{{ config('carrera.portal_url') }}" target="_blank" rel="noopener">Portal de la UNSXX</a></li>
                    <li><a href="{{ config('carrera.sia_url') }}" target="_blank" rel="noopener">SIA UNSXX (notas)</a></li>
                    <li><a href="{{ config('carrera.moodle_url') }}" target="_blank" rel="noopener">Aulas virtuales Moodle</a></li>
                </ul>
            </div>
        </div>
        <hr class="border-secondary">
        <p class="small text-center mb-0">&copy; {{ date('Y') }} {{ config('carrera.nombre') }} · {{ config('carrera.universidad') }}. Llallagua – Potosí – Bolivia.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
