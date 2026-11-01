<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contenido;
use Illuminate\Http\Request;

class ContenidoController extends Controller
{
    public function index()
    {
        $orden = array_merge(['presentacion'], Contenido::orden());
        $contenidos = Contenido::whereIn('clave', $orden)->get()
            ->sortBy(fn ($c) => array_search($c->clave, $orden))->values();

        return view('admin.contenidos.index', compact('contenidos'));
    }

    public function edit(Contenido $contenido)
    {
        return view('admin.contenidos.edit', compact('contenido'));
    }

    public function update(Request $request, Contenido $contenido)
    {
        $datos = $request->validate([
            'titulo' => ['required', 'string', 'max:200'],
            'contenido' => ['required', 'string', 'max:30000'],
        ]);
        $contenido->update($datos + ['user_id' => $request->user()->id]);

        return redirect()->route('admin.contenidos.index')->with('exito', 'Contenido actualizado.');
    }
}
