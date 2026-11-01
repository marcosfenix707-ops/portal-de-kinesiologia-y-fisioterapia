@extends('layouts.admin')
@section('titulo', $usuario->exists ? 'Editar usuario' : 'Nuevo usuario')
@section('contenido')
<h1 class="h3 mb-3">{{ $usuario->exists ? 'Editar usuario' : 'Nuevo usuario' }}</h1>
<form method="post" class="card shadow-sm p-4" novalidate action="{{ $usuario->exists ? route('admin.usuarios.update', $usuario) : route('admin.usuarios.store') }}">
    @csrf @if($usuario->exists) @method('PUT') @endif
    <div class="row g-3">
        <div class="col-md-6"><label class="form-label" for="name">Nombre *</label><input class="form-control" id="name" name="name" value="{{ old('name', $usuario->name) }}" required></div>
        <div class="col-md-6"><label class="form-label" for="email">Correo *</label><input type="email" class="form-control" id="email" name="email" value="{{ old('email', $usuario->email) }}" required></div>
        <div class="col-md-6"><label class="form-label" for="password">Contraseña {{ $usuario->exists ? '(dejar vacío para conservar)' : '*' }}</label><input type="password" class="form-control" id="password" name="password" autocomplete="new-password" {{ $usuario->exists ? '' : 'required' }}><div class="form-text">Mínimo 8 caracteres.</div></div>
        <div class="col-md-6"><label class="form-label" for="password_confirmation">Confirmar contraseña</label><input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password"></div>
        <div class="col-md-6"><label class="form-label" for="role_id">Rol *</label><select class="form-select" id="role_id" name="role_id" required><option value="">Seleccione…</option>@foreach($roles as $r)<option value="{{ $r->id }}" @selected(old('role_id', $usuario->role_id) == $r->id)>{{ $r->nombre }} — {{ $r->descripcion }}</option>@endforeach</select></div>
        <div class="col-md-6 d-flex align-items-end"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="activo" name="activo" value="1" @checked(old('activo', $usuario->activo))><label class="form-check-label" for="activo">Usuario activo</label></div></div>
        <div class="col-12 d-flex gap-2"><button class="btn btn-brand" type="submit"><i class="bi bi-save"></i> Guardar</button><a class="btn btn-outline-secondary" href="{{ route('admin.usuarios.index') }}">Cancelar</a></div>
    </div>
</form>
@endsection
