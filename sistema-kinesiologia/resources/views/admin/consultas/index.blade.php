@extends('layouts.admin')
@section('titulo', 'Consultas')
@section('contenido')
<h1 class="h3 mb-3">Consultas recibidas</h1>
@forelse($consultas as $c)
    <div class="card shadow-sm mb-3"><div class="card-body">
        <div class="d-flex justify-content-between flex-wrap gap-2"><div><h2 class="h6 mb-0">{{ $c->asunto }}</h2><small class="text-muted">{{ $c->nombre }} · <a href="mailto:{{ $c->correo }}">{{ $c->correo }}</a> · {{ $c->created_at->format('d/m/Y H:i') }}</small></div>
            <span class="badge {{ $c->atendida ? 'text-bg-success' : 'text-bg-warning' }} align-self-start">{{ $c->atendida ? 'Atendida' : 'Pendiente' }}</span></div>
        <p class="mt-2 mb-2" style="white-space:pre-line">{{ $c->mensaje }}</p>
        <div class="d-flex gap-2">
            <form method="post" action="{{ route('admin.consultas.update', $c) }}">@csrf @method('PUT')<button class="btn btn-sm btn-outline-success"><i class="bi bi-check2-circle"></i> {{ $c->atendida ? 'Marcar pendiente' : 'Marcar atendida' }}</button></form>
            <form method="post" action="{{ route('admin.consultas.destroy', $c) }}" onsubmit="return confirm('¿Eliminar esta consulta?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
        </div></div></div>
@empty<p class="text-muted">No hay consultas.</p>@endforelse
{{ $consultas->links() }}
@endsection
