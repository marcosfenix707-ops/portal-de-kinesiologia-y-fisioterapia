@extends('layouts.public')
@section('titulo', 'Noticias y avisos')
@section('contenido')
<h1 class="section-title">Noticias y avisos</h1>
<div class="row g-3">
    @forelse($noticias as $noticia)
        <div class="col-md-6 col-lg-4 reveal">
            <div class="card card-hover h-100">
                @if($noticia->imagen)<img src="{{ asset('storage/'.$noticia->imagen) }}" class="card-img-top" alt="" style="height:180px;object-fit:cover">@endif
                <div class="card-body">
                    <p class="small text-muted mb-1"><i class="bi bi-calendar3"></i> {{ $noticia->fecha_publicacion?->format('d/m/Y') }}</p>
                    <h2 class="h6 fw-bold">{{ $noticia->titulo }}</h2>
                    <p class="small mb-0">{{ $noticia->resumen ?: \Illuminate\Support\Str::limit(strip_tags($noticia->contenido), 140) }}</p>
                </div>
                <div class="card-footer bg-white border-0"><a href="{{ route('noticias.show', $noticia) }}" class="stretched-link small">Leer más →</a></div>
            </div>
        </div>
    @empty
        <p class="text-muted">No hay noticias publicadas.</p>
    @endforelse
</div>
<div class="mt-4">{{ $noticias->links() }}</div>
@endsection
