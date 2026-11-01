@extends('layouts.public')
@section('titulo', 'Inicio')

@section('hero')
<section class="hero py-5">
    <div class="container py-4 position-relative" style="z-index:1">
        <p class="text-warning fw-semibold mb-2"><i class="bi bi-stars"></i> {{ config('carrera.universidad') }} · {{ config('carrera.area') }}</p>
        <h1 class="display-5 mb-3">Carrera de Kinesiología y Fisioterapia</h1>
        <p class="lead mb-4">{{ $presentacion?->contenido ?? 'Portal oficial de la carrera.' }}</p>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('preinscripcion') }}" class="btn btn-accent btn-lg"><i class="bi bi-pencil-square"></i> Preinscribirme</a>
            <a href="{{ route('carrera.index') }}" class="btn btn-outline-light btn-lg">Conocer la carrera</a>
        </div>
    </div>
</section>
@endsection

@section('contenido')
<div class="row g-3 mt-1 mb-5">
    @foreach([
        ['bi-folder2-open', 'Documentos', 'Reglamentos, resoluciones y comunicados.', route('documentos.index')],
        ['bi-megaphone', 'Noticias y avisos', 'Información oficial de la carrera.', route('noticias.index')],
        ['bi-journal-text', 'Plan de estudios', 'Asignaturas y carga horaria.', route('carrera.seccion', 'plan_estudios')],
        ['bi-person-badge', 'SIA UNSXX', 'Consulta de notas en el sistema académico.', config('carrera.sia_url')],
    ] as [$icono, $titulo, $texto, $enlace])
        <div class="col-6 col-lg-3 reveal">
            <a href="{{ $enlace }}" class="text-decoration-none text-reset" @if(str_starts_with($enlace, 'http') && ! str_contains($enlace, request()->getHost())) target="_blank" rel="noopener" @endif>
                <div class="card card-hover h-100 text-center p-3">
                    <div class="icon-circle mx-auto mb-2"><i class="bi {{ $icono }}"></i></div>
                    <h2 class="h6 fw-bold mb-1">{{ $titulo }}</h2>
                    <p class="small text-muted mb-0">{{ $texto }}</p>
                </div>
            </a>
        </div>
    @endforeach
</div>

<section class="mb-5 reveal">
    <h2 class="section-title">Últimas noticias</h2>
    <div class="row g-3">
        @forelse($noticias as $noticia)
            <div class="col-md-4">
                <div class="card card-hover h-100">
                    @if($noticia->imagen)<img src="{{ asset('storage/'.$noticia->imagen) }}" class="card-img-top" alt="" style="height:170px;object-fit:cover">@endif
                    <div class="card-body">
                        <p class="small text-muted mb-1"><i class="bi bi-calendar3"></i> {{ $noticia->fecha_publicacion?->format('d/m/Y') }}</p>
                        <h3 class="h6 fw-bold">{{ $noticia->titulo }}</h3>
                        <p class="small mb-0">{{ $noticia->resumen ?: \Illuminate\Support\Str::limit(strip_tags($noticia->contenido), 120) }}</p>
                    </div>
                    <div class="card-footer bg-white border-0"><a href="{{ route('noticias.show', $noticia) }}" class="stretched-link small">Leer más →</a></div>
                </div>
            </div>
        @empty
            <p class="text-muted">Todavía no hay noticias publicadas.</p>
        @endforelse
    </div>
</section>

<section class="mb-5 reveal">
    <h2 class="section-title">Documentos recientes</h2>
    <div class="list-group shadow-sm">
        @forelse($documentos as $doc)
            <a href="{{ route('documentos.show', $doc) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                <span><i class="bi bi-file-earmark-text text-brand"></i> <strong>{{ $doc->titulo }}</strong> <span class="badge text-bg-light">{{ $doc->categoria->nombre }}</span></span>
                <small class="text-muted">{{ ($doc->fecha_documento ?? $doc->created_at)->format('d/m/Y') }}</small>
            </a>
        @empty
            <div class="list-group-item text-muted">Todavía no hay documentos publicados.</div>
        @endforelse
    </div>
    <a href="{{ route('documentos.index') }}" class="btn btn-sm btn-brand mt-3">Ver todos los documentos</a>
</section>

<section class="reveal">
    <h2 class="section-title">¿Dónde estamos?</h2>
    <div class="row g-3 align-items-center">
        <div class="col-lg-5">
            <p><i class="bi bi-geo-alt-fill text-brand"></i> {{ config('carrera.direccion') }}</p>
            <a class="btn btn-brand" target="_blank" rel="noopener" href="https://www.google.com/maps/search/?api=1&query={{ urlencode(config('carrera.mapa_busqueda')) }}"><i class="bi bi-map"></i> Abrir en Google Maps</a>
        </div>
        <div class="col-lg-7">
            <iframe class="map-frame" title="Ubicación de la carrera en Google Maps" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                    src="https://www.google.com/maps?q={{ urlencode(config('carrera.mapa_busqueda')) }}&output=embed"></iframe>
        </div>
    </div>
</section>
@endsection
