@extends('layouts.public')
@section('titulo', 'La carrera')
@section('contenido')
<h1 class="section-title">La carrera</h1>
<div class="row g-3">
    @foreach($contenidos as $c)
        <div class="col-md-6 col-lg-4 reveal">
            <a class="text-decoration-none text-reset" href="{{ route('carrera.seccion', $c) }}">
                <div class="card card-hover h-100 p-3">
                    <h2 class="h6 fw-bold text-brand"><i class="bi bi-chevron-right"></i> {{ $c->titulo }}</h2>
                    <p class="small text-muted mb-0">{{ \Illuminate\Support\Str::limit(strip_tags($c->contenido), 140) }}</p>
                </div>
            </a>
        </div>
    @endforeach
</div>
@endsection
