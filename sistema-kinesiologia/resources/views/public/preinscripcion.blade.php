@extends('layouts.public')
@section('titulo', 'Preinscripción en línea')
@section('contenido')
<div class="row justify-content-center"><div class="col-lg-8">
    <h1 class="section-title">Preinscripción en línea</h1>
    <p>Complete el formulario si desea ingresar a la carrera. La dirección de carrera se comunicará con usted para orientarle sobre los requisitos y las modalidades de admisión.</p>
    <form method="post" action="{{ route('preinscripcion.guardar') }}" class="card border-0 shadow-sm p-4" novalidate>
        @csrf
        <div class="trampa" aria-hidden="true"><label>Sitio web <input type="text" name="sitio_web" tabindex="-1" autocomplete="off"></label></div>
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label" for="nombres">Nombres *</label><input class="form-control @error('nombres') is-invalid @enderror" id="nombres" name="nombres" value="{{ old('nombres') }}" required></div>
            <div class="col-md-6"><label class="form-label" for="apellidos">Apellidos *</label><input class="form-control @error('apellidos') is-invalid @enderror" id="apellidos" name="apellidos" value="{{ old('apellidos') }}" required></div>
            <div class="col-md-6"><label class="form-label" for="correo">Correo electrónico *</label><input type="email" class="form-control @error('correo') is-invalid @enderror" id="correo" name="correo" value="{{ old('correo') }}" required></div>
            <div class="col-md-6"><label class="form-label" for="telefono">Teléfono / WhatsApp *</label><input class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono') }}" required></div>
            <div class="col-12"><label class="form-label" for="mensaje">Mensaje (opcional)</label><textarea class="form-control" id="mensaje" name="mensaje" rows="3" maxlength="1000">{{ old('mensaje') }}</textarea></div>
            <div class="col-12"><button class="btn btn-brand btn-lg" type="submit"><i class="bi bi-send"></i> Enviar preinscripción</button></div>
        </div>
    </form>
</div></div>
@endsection
