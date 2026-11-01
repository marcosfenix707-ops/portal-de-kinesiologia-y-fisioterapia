@extends('layouts.admin')
@section('titulo', 'Usuarios y roles')
@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3"><h1 class="h3 mb-0">Usuarios y roles</h1><a class="btn btn-brand" href="{{ route('admin.usuarios.create') }}"><i class="bi bi-person-plus"></i> Nuevo usuario</a></div>
<div class="card shadow-sm table-responsive"><table class="table table-hover align-middle mb-0"><thead class="table-light"><tr><th>Nombre</th><th>Correo</th><th>Rol</th><th>Estado</th><th class="text-end">Acciones</th></tr></thead><tbody>
@foreach($usuarios as $u)
    <tr><td>{{ $u->name }}</td><td>{{ $u->email }}</td><td>{{ $u->role?->nombre ?? '—' }}</td><td><span class="badge {{ $u->activo ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $u->activo ? 'Activo' : 'Inactivo' }}</span></td>
    <td class="text-end text-nowrap"><a class="btn btn-sm btn-outline-primary" href="{{ route('admin.usuarios.edit', $u) }}"><i class="bi bi-pencil"></i></a>
        <form class="d-inline" method="post" action="{{ route('admin.usuarios.destroy', $u) }}" onsubmit="return confirm('¿Eliminar este usuario?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form></td></tr>
@endforeach
</tbody></table></div>
@endsection
