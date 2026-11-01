@extends('layouts.public')
@section('titulo', 'Acceso')
@section('contenido')
<div class="row justify-content-center"><div class="col-md-6 col-lg-4">
    <div class="card border-0 shadow p-4 mt-4">
        <div class="text-center mb-3"><div class="icon-circle"><i class="bi bi-shield-lock"></i></div><h1 class="h4 mt-2 text-brand">Acceso al panel</h1><p class="small text-muted">Solo personal autorizado de la carrera.</p></div>
        <form method="post" action="{{ route('login.ingresar') }}" novalidate>
            @csrf
            <div class="mb-3"><label class="form-label" for="email">Correo electrónico</label><input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"></div>
            <div class="mb-3"><label class="form-label" for="password">Contraseña</label><input type="password" class="form-control" id="password" name="password" required autocomplete="current-password"></div>
            <div class="form-check mb-3"><input class="form-check-input" type="checkbox" id="recordar" name="recordar" value="1"><label class="form-check-label" for="recordar">Mantener sesión iniciada</label></div>
            <div class="d-grid"><button class="btn btn-brand" type="submit"><i class="bi bi-box-arrow-in-right"></i> Ingresar</button></div>
        </form>
    </div>
</div></div>
@endsection
