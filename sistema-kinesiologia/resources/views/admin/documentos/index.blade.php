@extends('layouts.admin')
@section('titulo', 'Documentos')
@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3"><h1 class="h3 mb-0">Documentos</h1><a class="btn btn-brand" href="{{ route('admin.documentos.create') }}"><i class="bi bi-plus-lg"></i> Nuevo documento</a></div>
<form class="mb-3" method="get"><div class="input-group"><input type="search" name="q" value="{{ $q }}" class="form-control" placeholder="Buscar por título" aria-label="Buscar"><button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button></div></form>
<div class="table-responsive card shadow-sm"><table class="table table-hover align-middle mb-0">
    <thead class="table-light"><tr><th>Título</th><th>Categoría</th><th>Visibilidad</th><th>Tamaño</th><th>Subido por</th><th class="text-end">Acciones</th></tr></thead>
    <tbody>
    @forelse($documentos as $d)
        <tr><td>{{ $d->titulo }}<div class="small text-muted">{{ $d->nombre_original }}</div></td><td>{{ $d->categoria->nombre }}</td>
            <td><span class="badge {{ $d->publico ? 'text-bg-success' : 'text-bg-warning' }}">{{ $d->publico ? 'Público' : 'Interno' }}</span></td>
            <td>{{ $d->tamanoLegible() }}</td><td>{{ $d->usuario->name }}</td>
            <td class="text-end text-nowrap">
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('documentos.show', $d) }}" target="_blank" title="Ver"><i class="bi bi-eye"></i></a>
                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.documentos.edit', $d) }}" title="Editar"><i class="bi bi-pencil"></i></a>
                <form class="d-inline" method="post" action="{{ route('admin.documentos.destroy', $d) }}" onsubmit="return confirm('¿Eliminar este documento?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" title="Eliminar"><i class="bi bi-trash"></i></button></form>
            </td></tr>
    @empty
        <tr><td colspan="6" class="text-center text-muted py-4">No hay documentos.</td></tr>
    @endforelse
    </tbody></table></div>
<div class="mt-3">{{ $documentos->links() }}</div>
@endsection
