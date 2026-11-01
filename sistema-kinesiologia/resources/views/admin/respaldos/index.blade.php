@extends('layouts.admin')
@section('titulo', 'Respaldos')
@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3"><h1 class="h3 mb-0">Copias de seguridad</h1>
    <form method="post" action="{{ route('admin.respaldos.store') }}">@csrf<button class="btn btn-brand"><i class="bi bi-hdd-network"></i> Generar respaldo ahora</button></form></div>
<p class="text-muted">El sistema genera un respaldo automático de la base de datos todos los días a las 02:00 y conserva los 14 más recientes. Descargue periódicamente una copia y guárdela fuera del servidor.</p>
<div class="card shadow-sm table-responsive"><table class="table align-middle mb-0"><thead class="table-light"><tr><th>Archivo</th><th>Fecha</th><th>Tamaño</th><th class="text-end">Descargar</th></tr></thead><tbody>
@forelse($respaldos as $r)
    <tr><td>{{ $r['nombre'] }}</td><td>{{ \Carbon\Carbon::createFromTimestamp($r['fecha'])->format('d/m/Y H:i') }}</td><td>{{ number_format($r['tamano'] / 1024, 0) }} KB</td><td class="text-end"><a class="btn btn-sm btn-outline-primary" href="{{ route('admin.respaldos.descargar', $r['nombre']) }}"><i class="bi bi-download"></i></a></td></tr>
@empty<tr><td colspan="4" class="text-center text-muted py-4">Todavía no hay respaldos.</td></tr>@endforelse
</tbody></table></div>
@endsection
