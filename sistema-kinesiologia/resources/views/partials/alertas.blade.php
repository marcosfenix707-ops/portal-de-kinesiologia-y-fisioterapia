@if(session('exito'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle"></i> {{ session('exito') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
@endif
@if($errors->any())
    <div class="alert alert-danger" role="alert">
        <strong>Revise los siguientes datos:</strong>
        <ul class="mb-0">@foreach($errors->all() as $mensaje)<li>{{ $mensaje }}</li>@endforeach</ul>
    </div>
@endif
