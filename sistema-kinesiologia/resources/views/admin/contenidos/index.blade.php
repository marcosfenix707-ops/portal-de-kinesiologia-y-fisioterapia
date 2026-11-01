@extends('layouts.admin')
@section('titulo', 'Contenidos de la carrera')
@section('contenido')
<h1 class="h3 mb-3">Contenidos de la carrera</h1>
<p class="text-muted">Edite aquí la información que se muestra en la sección “La carrera” del portal: plan de estudios, plantel docente, horarios, modalidades y estructura organizativa.</p>
<div class="card shadow-sm table-responsive"><table class="table table-hover align-middle mb-0"><thead class="table-light"><tr><th>Sección</th><th>Última actualización</th><th class="text-end">Acciones</th></tr></thead><tbody>
@foreach($contenidos as $c)
    <tr><td>{{ $c->titulo }}</td><td>{{ $c->updated_at->format('d/m/Y H:i') }}</td><td class="text-end"><a class="btn btn-sm btn-outline-primary" href="{{ route('admin.contenidos.edit', $c) }}"><i class="bi bi-pencil"></i> Editar</a></td></tr>
@endforeach
</tbody></table></div>
@endsection
