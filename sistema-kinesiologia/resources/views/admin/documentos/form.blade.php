@extends('layouts.admin')
@section('titulo', $documento->exists ? 'Editar documento' : 'Nuevo documento')
@section('contenido')
<h1 class="h3 mb-3">{{ $documento->exists ? 'Editar documento' : 'Nuevo documento' }}</h1>
<form method="post" enctype="multipart/form-data" class="card shadow-sm p-4" novalidate
      action="{{ $documento->exists ? route('admin.documentos.update', $documento) : route('admin.documentos.store') }}">
    @csrf @if($documento->exists) @method('PUT') @endif
    <div class="row g-3">
        <div class="col-md-8"><label class="form-label" for="titulo">Título *</label><input class="form-control" id="titulo" name="titulo" value="{{ old('titulo', $documento->titulo) }}" required></div>
        <div class="col-md-4"><label class="form-label" for="categoria_id">Categoría *</label>
            <select class="form-select" id="categoria_id" name="categoria_id" required><option value="">Seleccione…</option>
                @foreach($categorias as $c)<option value="{{ $c->id }}" @selected(old('categoria_id', $documento->categoria_id) == $c->id)>{{ $c->nombre }}</option>@endforeach
            </select></div>
        <div class="col-12"><label class="form-label" for="descripcion">Descripción</label><textarea class="form-control" id="descripcion" name="descripcion" rows="2" maxlength="1000">{{ old('descripcion', $documento->descripcion) }}</textarea></div>
        <div class="col-md-4"><label class="form-label" for="fecha_documento">Fecha del documento</label><input type="date" class="form-control" id="fecha_documento" name="fecha_documento" value="{{ old('fecha_documento', $documento->fecha_documento?->format('Y-m-d')) }}"></div>
        <div class="col-md-8"><label class="form-label" for="archivo">Archivo {{ $documento->exists ? '(dejar vacío para conservar el actual)' : '*' }}</label>
            <input type="file" class="form-control" id="archivo" name="archivo" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png" {{ $documento->exists ? '' : 'required' }}>
            <div class="form-text">PDF, Word, Excel, PowerPoint o imagen. Máximo 20 MB.@if($documento->exists) Actual: {{ $documento->nombre_original }}@endif</div></div>
        <div class="col-12"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="publico" name="publico" value="1" @checked(old('publico', $documento->publico))><label class="form-check-label" for="publico">Documento público (visible para cualquier visitante). Si se desactiva, solo lo ven los usuarios con sesión iniciada.</label></div></div>
        <div class="col-12 d-flex gap-2"><button class="btn btn-brand" type="submit"><i class="bi bi-save"></i> Guardar</button><a class="btn btn-outline-secondary" href="{{ route('admin.documentos.index') }}">Cancelar</a></div>
    </div>
</form>
@endsection
