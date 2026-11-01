<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consulta;

class ConsultaController extends Controller
{
    public function index()
    {
        return view('admin.consultas.index', ['consultas' => Consulta::latest()->paginate(15)]);
    }

    public function update(Consulta $consulta)
    {
        $consulta->update(['atendida' => ! $consulta->atendida]);

        return back()->with('exito', 'Estado de la consulta actualizado.');
    }

    public function destroy(Consulta $consulta)
    {
        $consulta->delete();

        return back()->with('exito', 'Consulta eliminada.');
    }
}
