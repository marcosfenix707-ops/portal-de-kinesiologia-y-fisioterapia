@extends('layouts.admin')
@section('titulo', 'Categorías')
@section('contenido')
<h1 class="h3 mb-3">Categorías de documentos</h1>
<form method="post" action="{{ route('admin.categorias.store') }}" class="card shadow-sm p-3 mb-4"><h2 class="h6">Nueva categoría</h2>@csrf
    <div class="row g-2"><div class="col-md-4"><input class="form-control" name="nombre" placeholder="Nombre *" required maxlength="100"></div><div class="col-md-6"><input class="form-control" name="descripcion" placeholder="Descripción" maxlength="255"></div><div class="col-md-2 d-grid"><button class="btn btn-brand"><i class="bi bi-plus-lg"></i> Crear</button></div></div></form>
<div class="card shadow-sm"><div class="table-responsive"><table class="table align-middle mb-0"><thead class="table-light"><tr><th>Nombre</th><th>Descripción</th><th>Docs.</th><th class="text-end">Acciones</th></tr></thead><tbody>
@foreach($categorias as $c)
    <tr>
        <td><input form="cat{{ $c->id }}" class="form-control form-control-sm" name="nombre" value="{{ $c->nombre }}" required></td>
        <td><input form="cat{{ $c->id }}" class="form-control form-control-sm" name="descripcion" value="{{ $c->descripcion }}"></td>
        <td>{{ $c->documentos_count }}</td>
        <td class="text-end text-nowrap"><button form="cat{{ $c->id }}" class="btn btn-sm btn-outline-primary" title="Guardar"><i class="bi bi-save"></i></button>
            <form class="d-inline" method="post" action="{{ route('admin.categorias.destroy', $c) }}" onsubmit="return confirm('¿Eliminar esta categoría?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" title="Eliminar"><i class="bi bi-trash"></i></button></form></td></tr>
@endforeach
</tbody></table></div></div>
@foreach($categorias as $c)
<form method="post" action="{{ route('admin.categorias.update', $c) }}" id="cat{{ $c->id }}">@csrf @method('PUT')</form>
@endforeach
@endsection
