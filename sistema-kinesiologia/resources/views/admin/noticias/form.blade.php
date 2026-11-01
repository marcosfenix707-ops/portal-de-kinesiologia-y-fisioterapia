@extends('layouts.admin')
@section('titulo', $noticia->exists ? 'Editar noticia' : 'Nueva noticia')
@section('contenido')
<h1 class="h3 mb-3">{{ $noticia->exists ? 'Editar noticia' : 'Nueva noticia' }}</h1>
<form method="post" enctype="multipart/form-data" class="card shadow-sm p-4" novalidate action="{{ $noticia->exists ? route('admin.noticias.update', $noticia) : route('admin.noticias.store') }}">
    @csrf @if($noticia->exists) @method('PUT') @endif
    <div class="row g-3">
        <div class="col-12"><label class="form-label" for="titulo">Título *</label><input class="form-control" id="titulo" name="titulo" value="{{ old('titulo', $noticia->titulo) }}" required></div>
        <div class="col-12"><label class="form-label" for="resumen">Resumen</label><input class="form-control" id="resumen" name="resumen" maxlength="500" value="{{ old('resumen', $noticia->resumen) }}"></div>
        <div class="col-12"><label class="form-label" for="contenido">Contenido *</label><textarea class="form-control" id="contenido" name="contenido" rows="8" required>{{ old('contenido', $noticia->contenido) }}</textarea><div class="form-text">Deje una línea en blanco para separar párrafos. Una línea que empiece con “- ” forma una lista.</div></div>
        <div class="col-md-8"><label class="form-label" for="imagen">Imagen (opcional)</label><input type="file" class="form-control" id="imagen" name="imagen" accept=".jpg,.jpeg,.png,.webp"><div class="form-text">JPG, PNG o WebP. Máximo 2 MB.</div>@if($noticia->imagen)<img class="mt-2 rounded" style="max-height:90px" src="{{ asset('storage/'.$noticia->imagen) }}" alt="Imagen actual">@endif</div>
        <div class="col-md-4 d-flex align-items-end"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="publicada" name="publicada" value="1" @checked(old('publicada', $noticia->publicada))><label class="form-check-label" for="publicada">Publicar en el portal</label></div></div>
        <div class="col-12 d-flex gap-2"><button class="btn btn-brand" type="submit"><i class="bi bi-save"></i> Guardar</button><a class="btn btn-outline-secondary" href="{{ route('admin.noticias.index') }}">Cancelar</a></div>
    </div>
</form>
@endsection
