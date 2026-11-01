@extends('layouts.admin')
@section('titulo', 'Resumen')
@section('contenido')
<h1 class="h3 mb-4">Resumen general</h1>
<div class="row g-3 mb-4">
    @foreach([
        ['Documentos', $totalDocumentos, 'bi-folder2-open', route('admin.documentos.index')],
        ['Noticias publicadas', $totalNoticias, 'bi-megaphone', route('admin.noticias.index')],
        ['Preinscripciones pendientes', $preinscripcionesPendientes, 'bi-pencil-square', route('admin.preinscripciones.index', ['estado' => 'pendiente'])],
        ['Consultas sin atender', $consultasPendientes, 'bi-chat-dots', route('admin.consultas.index')],
    ] as [$t, $n, $i, $r])
        <div class="col-sm-6 col-xl-3"><a href="{{ $r }}" class="text-decoration-none text-reset"><div class="card stat-card shadow-sm card-hover"><div class="card-body d-flex justify-content-between align-items-center"><div><div class="text-muted small">{{ $t }}</div><div class="display-6 fw-bold">{{ $n }}</div></div><i class="bi {{ $i }} fs-1 text-brand"></i></div></div></a></div>
    @endforeach
</div>
<div class="row g-3">
    <div class="col-lg-6"><div class="card shadow-sm"><div class="card-header bg-white fw-bold">Últimas preinscripciones</div><ul class="list-group list-group-flush">
        @forelse($ultimasPreinscripciones as $p)<li class="list-group-item d-flex justify-content-between"><a href="{{ route('admin.preinscripciones.show', $p) }}">{{ $p->nombres }} {{ $p->apellidos }}</a><span class="badge text-bg-light">{{ $p->estado }}</span></li>
        @empty<li class="list-group-item text-muted">Sin registros.</li>@endforelse
    </ul></div></div>
    <div class="col-lg-6"><div class="card shadow-sm"><div class="card-header bg-white fw-bold">Últimas consultas</div><ul class="list-group list-group-flush">
        @forelse($ultimasConsultas as $c)<li class="list-group-item d-flex justify-content-between"><span>{{ $c->asunto }} <small class="text-muted">— {{ $c->nombre }}</small></span><span class="badge {{ $c->atendida ? 'text-bg-success' : 'text-bg-warning' }}">{{ $c->atendida ? 'Atendida' : 'Pendiente' }}</span></li>
        @empty<li class="list-group-item text-muted">Sin registros.</li>@endforelse
    </ul></div></div>
</div>
@endsection
