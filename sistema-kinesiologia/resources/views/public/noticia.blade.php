@extends('layouts.public')
@section('titulo', $noticia->titulo)
@section('contenido')
<nav aria-label="breadcrumb"><ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('inicio') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('noticias.index') }}">Noticias</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ \Illuminate\Support\Str::limit($noticia->titulo, 40) }}</li>
</ol></nav>
<article class="card border-0 shadow-sm p-4 reveal">
    <h1 class="h2 fw-bold text-brand">{{ $noticia->titulo }}</h1>
    <p class="text-muted small"><i class="bi bi-calendar3"></i> {{ $noticia->fecha_publicacion?->format('d/m/Y') }}</p>
    @if($noticia->imagen)<img src="{{ asset('storage/'.$noticia->imagen) }}" class="img-fluid rounded mb-3" alt="Imagen de la noticia">@endif
    <div class="contenido-texto">{!! \App\Support\Texto::html($noticia->contenido) !!}</div>
</article>
@endsection
