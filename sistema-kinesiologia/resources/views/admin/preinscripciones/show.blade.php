@extends('layouts.admin')
@section('titulo', 'Preinscripción')
@section('contenido')
<h1 class="h3 mb-3">Preinscripción de {{ $preinscripcion->nombres }} {{ $preinscripcion->apellidos }}</h1>
<div class="card shadow-sm p-4 mb-3">
    <dl class="row mb-0">
        <dt class="col-sm-3">Correo</dt><dd class="col-sm-9">{{ $preinscripcion->correo }}</dd>
        <dt class="col-sm-3">Teléfono</dt><dd class="col-sm-9">{{ $preinscripcion->telefono }}</dd>
        <dt class="col-sm-3">Fecha</dt><dd class="col-sm-9">{{ $preinscripcion->created_at->format('d/m/Y H:i') }}</dd>
        <dt class="col-sm-3">Mensaje</dt><dd class="col-sm-9">{{ $preinscripcion->mensaje ?: '—' }}</dd>
    </dl>
</div>
<form method="post" action="{{ route('admin.preinscripciones.update', $preinscripcion) }}" class="d-flex gap-2 align-items-end mb-3">@csrf @method('PUT')
    <div><label class="form-label" for="estado">Estado</label><select class="form-select" id="estado" name="estado">@foreach($estados as $e)<option value="{{ $e }}" @selected($preinscripcion->estado === $e)>{{ ucfirst($e) }}</option>@endforeach</select></div>
    <button class="btn btn-brand" type="submit"><i class="bi bi-save"></i> Actualizar</button>
</form>
<div class="d-flex gap-2"><a class="btn btn-outline-secondary" href="{{ route('admin.preinscripciones.index') }}">Volver</a>
<form method="post" action="{{ route('admin.preinscripciones.destroy', $preinscripcion) }}" onsubmit="return confirm('¿Eliminar esta preinscripción?')">@csrf @method('DELETE')<button class="btn btn-outline-danger"><i class="bi bi-trash"></i> Eliminar</button></form></div>
@endsection
