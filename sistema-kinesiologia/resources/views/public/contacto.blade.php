@extends('layouts.public')
@section('titulo', 'Contacto')
@section('contenido')
<h1 class="section-title">Contacto</h1>
<div class="row g-4">
    <div class="col-lg-6">
        <form method="post" action="{{ route('contacto.guardar') }}" class="card border-0 shadow-sm p-4" novalidate>
            @csrf
            <div class="trampa" aria-hidden="true"><label>Sitio web <input type="text" name="sitio_web" tabindex="-1" autocomplete="off"></label></div>
            <div class="mb-3"><label class="form-label" for="nombre">Nombre *</label><input class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required></div>
            <div class="mb-3"><label class="form-label" for="correo">Correo electrónico *</label><input type="email" class="form-control @error('correo') is-invalid @enderror" id="correo" name="correo" value="{{ old('correo') }}" required></div>
            <div class="mb-3"><label class="form-label" for="asunto">Asunto *</label><input class="form-control @error('asunto') is-invalid @enderror" id="asunto" name="asunto" value="{{ old('asunto') }}" required></div>
            <div class="mb-3"><label class="form-label" for="mensaje">Mensaje *</label><textarea class="form-control @error('mensaje') is-invalid @enderror" id="mensaje" name="mensaje" rows="5" maxlength="2000" required>{{ old('mensaje') }}</textarea></div>
            <button class="btn btn-brand" type="submit"><i class="bi bi-send"></i> Enviar consulta</button>
        </form>
    </div>
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm p-4 mb-3">
            <h2 class="h5 text-brand">Datos de la carrera</h2>
            <p class="mb-1"><i class="bi bi-geo-alt"></i> {{ config('carrera.direccion') }}</p>
            @if(config('carrera.correo'))<p class="mb-1"><i class="bi bi-envelope"></i> {{ config('carrera.correo') }}</p>@endif
            @if(config('carrera.telefono'))<p class="mb-0"><i class="bi bi-telephone"></i> {{ config('carrera.telefono') }}</p>@endif
        </div>
        <iframe class="map-frame" title="Ubicación de la carrera en Google Maps" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                src="https://www.google.com/maps?q={{ urlencode(config('carrera.mapa_busqueda')) }}&output=embed"></iframe>
    </div>
</div>
@endsection
