<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class RespaldoController extends Controller
{
    public function index()
    {
        $disco = Storage::disk('local');
        $respaldos = collect($disco->files('respaldos'))
            ->filter(fn ($f) => str_ends_with($f, '.sql'))
            ->map(fn ($f) => ['nombre' => basename($f), 'tamano' => $disco->size($f), 'fecha' => $disco->lastModified($f)])
            ->sortByDesc('fecha')->values();

        return view('admin.respaldos.index', compact('respaldos'));
    }

    public function store()
    {
        $codigo = Artisan::call('respaldo:generar');
        $salida = trim(Artisan::output());

        return back()->with($codigo === 0 ? 'exito' : 'error', $salida !== '' ? $salida : 'Proceso finalizado.');
    }

    public function descargar(string $archivo)
    {
        $ruta = 'respaldos/'.basename($archivo);
        abort_unless(str_ends_with($ruta, '.sql') && Storage::disk('local')->exists($ruta), 404);

        return Storage::disk('local')->download($ruta);
    }
}
