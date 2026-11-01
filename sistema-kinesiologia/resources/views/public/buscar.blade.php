@extends('layouts.public')
@section('titulo', 'Buscar')
@section('contenido')
<h1 class="section-title">Resultados de búsqueda</h1>
<form class="row g-2 mb-4" method="get" action="{{ route('buscar') }}">
    <div class="col-md-9"><input type="search" name="q" value="{{ $q }}" class="form-control" placeholder="Escriba al menos 2 caracteres" aria-label="Buscar"></div>
    <div class="col-md-3 d-grid"><button class="btn btn-brand" type="submit"><i class="bi bi-search"></i> Buscar</button></div>
</form>
@if(mb_strlen($q) < 2)
    <p class="text-muted">Escriba un término para buscar en documentos, noticias y secciones de la carrera.</p>
@else
    @php $total = $resultados['documentos']->count() + $resultados['noticias']->count() + $resultados['secciones']->count(); @endphp
    <p class="text-muted">{{ $total }} resultado(s) para “{{ $q }}”.</p>
    @if($resultados['documentos']->count())
        <h2 class="h5 text-brand mt-4">Documentos</h2>
        <div class="list-group mb-3">@foreach($resultados['documentos'] as $d)
            <a class="list-group-item list-group-item-action" href="{{ route('documentos.show', $d) }}"><i class="bi bi-file-earmark-text"></i> {{ $d->titulo }} <span class="badge text-bg-light">{{ $d->categoria->nombre }}</span></a>
        @endforeach</div>
    @endif
    @if($resultados['noticias']->count())
        <h2 class="h5 text-brand mt-4">Noticias</h2>
        <div class="list-group mb-3">@foreach($resultados['noticias'] as $n)
            <a class="list-group-item list-group-item-action" href="{{ route('noticias.show', $n) }}"><i class="bi bi-megaphone"></i> {{ $n->titulo }}</a>
        @endforeach</div>
    @endif
    @if($resultados['secciones']->count())
        <h2 class="h5 text-brand mt-4">La carrera</h2>
        <div class="list-group mb-3">@foreach($resultados['secciones'] as $s)
            <a class="list-group-item list-group-item-action" href="{{ route('carrera.seccion', $s) }}"><i class="bi bi-journal-text"></i> {{ $s->titulo }}</a>
        @endforeach</div>
    @endif
@endif
@endsection
