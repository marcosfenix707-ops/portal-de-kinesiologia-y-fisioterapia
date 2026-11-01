@extends('layouts.public')
@section('titulo', $contenido->titulo)
@section('contenido')
<nav aria-label="breadcrumb"><ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('inicio') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('carrera.index') }}">La carrera</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $contenido->titulo }}</li>
</ol></nav>
<article class="card border-0 shadow-sm p-4 reveal">
    <h1 class="section-title">{{ $contenido->titulo }}</h1>
    <div class="contenido-texto">{!! \App\Support\Texto::html($contenido->contenido) !!}</div>
    <p class="small text-muted mb-0 mt-3">Actualizado: {{ $contenido->updated_at->format('d/m/Y') }}</p>
</article>
@endsection
