@extends('layouts.public')
@section('titulo', $documento->titulo)
@section('contenido')
<nav aria-label="breadcrumb"><ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('inicio') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('documentos.index') }}">Documentos</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ \Illuminate\Support\Str::limit($documento->titulo, 40) }}</li>
</ol></nav>
<div class="card border-0 shadow-sm p-4 mb-3">
    <h1 class="h3 fw-bold text-brand">{{ $documento->titulo }}</h1>
    <p class="mb-2">
        <span class="badge text-bg-light">{{ $documento->categoria->nombre }}</span>
        <small class="text-muted">{{ ($documento->fecha_documento ?? $documento->created_at)->format('d/m/Y') }} · {{ $documento->nombre_original }} · {{ $documento->tamanoLegible() }}</small>
    </p>
    @if($documento->descripcion)<p>{{ $documento->descripcion }}</p>@endif
    <div><a class="btn btn-brand" href="{{ route('documentos.descargar', $documento) }}"><i class="bi bi-download"></i> Descargar</a></div>
</div>
@if($documento->mime === 'application/pdf')
    <iframe class="preview-frame" src="{{ route('documentos.archivo', $documento) }}" title="Vista previa de {{ $documento->titulo }}"></iframe>
@elseif($documento->esPrevisualizable())
    <img src="{{ route('documentos.archivo', $documento) }}" class="img-fluid rounded shadow-sm" alt="Vista previa de {{ $documento->titulo }}">
@else
    <div class="alert alert-info"><i class="bi bi-info-circle"></i> La vista previa no está disponible para este tipo de archivo. Descárguelo para abrirlo.</div>
@endif
@endsection
