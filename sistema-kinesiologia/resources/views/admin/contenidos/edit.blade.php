@extends('layouts.admin')
@section('titulo', 'Editar contenido')
@section('contenido')
<h1 class="h3 mb-3">Editar: {{ $contenido->titulo }}</h1>
<form method="post" action="{{ route('admin.contenidos.update', $contenido) }}" class="card shadow-sm p-4" novalidate>
    @csrf @method('PUT')
    <div class="mb-3"><label class="form-label" for="titulo">Título *</label><input class="form-control" id="titulo" name="titulo" value="{{ old('titulo', $contenido->titulo) }}" required></div>
    <div class="mb-3"><label class="form-label" for="contenido">Contenido *</label><textarea class="form-control" id="contenido" name="contenido" rows="14" required>{{ old('contenido', $contenido->contenido) }}</textarea><div class="form-text">Deje una línea en blanco para separar párrafos. Una línea que empiece con “- ” forma una lista.</div></div>
    <div class="d-flex gap-2"><button class="btn btn-brand" type="submit"><i class="bi bi-save"></i> Guardar</button><a class="btn btn-outline-secondary" href="{{ route('admin.contenidos.index') }}">Cancelar</a></div>
</form>
@endsection
