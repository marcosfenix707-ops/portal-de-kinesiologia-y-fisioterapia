<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Preinscripcion;
use Illuminate\Http\Request;

class PreinscripcionController extends Controller
{
    public const ESTADOS = ['pendiente', 'contactado', 'descartada'];

    public function index(Request $request)
    {
        $estado = $request->query('estado');
        $preinscripciones = Preinscripcion::query()
            ->when(in_array($estado, self::ESTADOS, true), fn ($q) => $q->where('estado', $estado))
            ->latest()->paginate(15)->withQueryString();

        return view('admin.preinscripciones.index', ['preinscripciones' => $preinscripciones, 'estado' => $estado, 'estados' => self::ESTADOS]);
    }

    public function show(Preinscripcion $preinscripcion)
    {
        return view('admin.preinscripciones.show', ['preinscripcion' => $preinscripcion, 'estados' => self::ESTADOS]);
    }

    public function update(Request $request, Preinscripcion $preinscripcion)
    {
        $datos = $request->validate(['estado' => ['required', 'in:'.implode(',', self::ESTADOS)]]);
        $preinscripcion->update($datos);

        return back()->with('exito', 'Estado actualizado.');
    }

    public function destroy(Preinscripcion $preinscripcion)
    {
        $preinscripcion->delete();

        return redirect()->route('admin.preinscripciones.index')->with('exito', 'Preinscripción eliminada.');
    }
}
