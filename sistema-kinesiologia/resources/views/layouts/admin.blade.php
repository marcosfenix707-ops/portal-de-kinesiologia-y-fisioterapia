<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('titulo', 'Panel') | Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="container-fluid admin-wrap">
    <div class="row">
        <aside class="col-lg-2 admin-side p-3">
            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-2 text-white text-decoration-none mb-3">
                <i class="bi bi-heart-pulse-fill fs-3 text-warning"></i><span class="lh-sm"><strong>Panel</strong><small class="d-block opacity-75">Kinesiología y Fisioterapia</small></span>
            </a>
            <nav class="nav flex-column gap-1" aria-label="Menú del panel">
                @php
                    $items = [
                        ['admin.dashboard', 'bi-speedometer2', 'Resumen', 'admin.dashboard'],
                        ['admin.documentos.index', 'bi-folder2-open', 'Documentos', 'admin.documentos.*'],
                        ['admin.categorias.index', 'bi-tags', 'Categorías', 'admin.categorias.*'],
                        ['admin.noticias.index', 'bi-megaphone', 'Noticias y avisos', 'admin.noticias.*'],
                        ['admin.contenidos.index', 'bi-journal-text', 'Contenidos de la carrera', 'admin.contenidos.*'],
                        ['admin.preinscripciones.index', 'bi-pencil-square', 'Preinscripciones', 'admin.preinscripciones.*'],
                        ['admin.consultas.index', 'bi-chat-dots', 'Consultas', 'admin.consultas.*'],
                    ];
                    if (auth()->user()->esAdministrador()) {
                        $items[] = ['admin.usuarios.index', 'bi-people', 'Usuarios y roles', 'admin.usuarios.*'];
                        $items[] = ['admin.respaldos.index', 'bi-hdd', 'Respaldos', 'admin.respaldos.*'];
                    }
                @endphp
                @foreach($items as [$ruta, $icono, $texto, $patron])
                    <a class="nav-link {{ request()->routeIs($patron) ? 'active' : '' }}" href="{{ route($ruta) }}"><i class="bi {{ $icono }}"></i> {{ $texto }}</a>
                @endforeach
                <hr class="border-secondary my-2">
                <a class="nav-link" href="{{ route('inicio') }}" target="_blank"><i class="bi bi-box-arrow-up-right"></i> Ver portal</a>
            </nav>
        </aside>
        <div class="col-lg-10 p-0">
            <header class="bg-white border-bottom px-4 py-2 d-flex justify-content-between align-items-center">
                <span class="text-muted small">Conectado como <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->role?->nombre }})</span>
                <form method="post" action="{{ route('logout') }}">@csrf<button class="btn btn-sm btn-outline-secondary" type="submit"><i class="bi bi-box-arrow-right"></i> Salir</button></form>
            </header>
            <main class="p-4">
                @include('partials.alertas')
                @yield('contenido')
            </main>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
