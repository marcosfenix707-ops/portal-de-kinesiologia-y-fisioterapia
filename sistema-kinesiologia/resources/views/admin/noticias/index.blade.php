@extends('layouts.admin')
@section('titulo', 'Noticias y avisos')
@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3"><h1 class="h3 mb-0">Noticias y avisos</h1><a class="btn btn-brand" href="{{ route('admin.noticias.create') }}"><i class="bi bi-plus-lg"></i> Nueva noticia</a></div>
<div class="card shadow-sm table-responsive"><table class="table table-hover align-middle mb-0"><thead class="table-light"><tr><th>Título</th><th>Estado</th><th>Fecha</th><th>Autor</th><th class="text-end">Acciones</th></tr></thead><tbody>
@forelse($noticias as $n)
    <tr><td>{{ $n->titulo }}</td><td><span class="badge {{ $n->publicada ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $n->publicada ? 'Publicada' : 'Borrador' }}</span></td><td>{{ $n->fecha_publicacion?->format('d/m/Y') ?? '—' }}</td><td>{{ $n->autor->name }}</td>
    <td class="text-end text-nowrap"><a class="btn btn-sm btn-outline-primary" href="{{ route('admin.noticias.edit', $n) }}"><i class="bi bi-pencil"></i></a>
        <form class="d-inline" method="post" action="{{ route('admin.noticias.destroy', $n) }}" onsubmit="return confirm('¿Eliminar esta noticia?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form></td></tr>
@empty<tr><td colspan="5" class="text-center text-muted py-4">No hay noticias.</td></tr>@endforelse
</tbody></table></div><div class="mt-3">{{ $noticias->links() }}</div>
@endsection
