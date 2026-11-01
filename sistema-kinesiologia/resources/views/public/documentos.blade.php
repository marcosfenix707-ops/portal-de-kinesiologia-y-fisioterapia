@extends('layouts.public')
@section('titulo', 'Documentos')
@section('contenido')
<h1 class="section-title">Documentos oficiales</h1>
<form class="row g-2 mb-4" method="get" action="{{ route('documentos.index') }}">
    <div class="col-md-6"><input type="search" name="q" value="{{ $q }}" class="form-control" placeholder="Buscar por título o descripción" aria-label="Buscar documentos"></div>
    <div class="col-md-4">
        <select name="categoria" class="form-select" aria-label="Categoría">
            <option value="">Todas las categorías</option>
            @foreach($categorias as $cat)<option value="{{ $cat->id }}" @selected($categoria === $cat->id)>{{ $cat->nombre }}</option>@endforeach
        </select>
    </div>
    <div class="col-md-2 d-grid"><button class="btn btn-brand" type="submit"><i class="bi bi-funnel"></i> Filtrar</button></div>
</form>
<div class="row g-3">
    @forelse($documentos as $doc)
        <div class="col-12 reveal">
            <div class="card card-hover">
                <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div class="d-flex gap-3 align-items-start">
                        <div class="icon-circle"><i class="bi bi-file-earmark-text"></i></div>
                        <div>
                            <h2 class="h6 fw-bold mb-1">{{ $doc->titulo }}</h2>
                            <span class="badge text-bg-light">{{ $doc->categoria->nombre }}</span>
                            @unless($doc->publico)<span class="badge text-bg-warning">Interno</span>@endunless
                            <small class="text-muted ms-1">{{ ($doc->fecha_documento ?? $doc->created_at)->format('d/m/Y') }} · {{ $doc->tamanoLegible() }}</small>
                            @if($doc->descripcion)<p class="small mb-0 mt-1">{{ $doc->descripcion }}</p>@endif
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('documentos.show', $doc) }}"><i class="bi bi-eye"></i> Ver</a>
                        <a class="btn btn-sm btn-brand" href="{{ route('documentos.descargar', $doc) }}"><i class="bi bi-download"></i> Descargar</a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">No se encontraron documentos.</p>
    @endforelse
</div>
<div class="mt-4">{{ $documentos->links() }}</div>
@endsection
