@extends('layouts.admin')
@section('titulo', 'Preinscripciones')
@section('contenido')
<h1 class="h3 mb-3">Preinscripciones</h1>
<div class="btn-group mb-3" role="group" aria-label="Filtrar por estado">
    <a class="btn btn-sm {{ ! $estado ? 'btn-brand' : 'btn-outline-secondary' }}" href="{{ route('admin.preinscripciones.index') }}">Todas</a>
    @foreach($estados as $e)<a class="btn btn-sm {{ $estado === $e ? 'btn-brand' : 'btn-outline-secondary' }}" href="{{ route('admin.preinscripciones.index', ['estado' => $e]) }}">{{ ucfirst($e) }}</a>@endforeach
</div>
<div class="card shadow-sm table-responsive"><table class="table table-hover align-middle mb-0"><thead class="table-light"><tr><th>Postulante</th><th>Contacto</th><th>Fecha</th><th>Estado</th><th class="text-end">Acciones</th></tr></thead><tbody>
@forelse($preinscripciones as $p)
    <tr><td>{{ $p->nombres }} {{ $p->apellidos }}</td><td>{{ $p->correo }}<div class="small text-muted">{{ $p->telefono }}</div></td><td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
    <td><span class="badge {{ $p->estado === 'pendiente' ? 'text-bg-warning' : ($p->estado === 'contactado' ? 'text-bg-success' : 'text-bg-secondary') }}">{{ $p->estado }}</span></td>
    <td class="text-end"><a class="btn btn-sm btn-outline-primary" href="{{ route('admin.preinscripciones.show', $p) }}"><i class="bi bi-eye"></i> Ver</a></td></tr>
@empty<tr><td colspan="5" class="text-center text-muted py-4">No hay preinscripciones.</td></tr>@endforelse
</tbody></table></div><div class="mt-3">{{ $preinscripciones->links() }}</div>
@endsection
