<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoriaController extends Controller
{
    public function index()
    {
        return view('admin.categorias.index', ['categorias' => Categoria::withCount('documentos')->orderBy('nombre')->get()]);
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:100', 'unique:categorias,nombre'],
            'descripcion' => ['nullable', 'string', 'max:255'],
        ]);
        Categoria::create($datos);

        return back()->with('exito', 'Categoría creada.');
    }

    public function update(Request $request, Categoria $categoria)
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:100', Rule::unique('categorias', 'nombre')->ignore($categoria->id)],
            'descripcion' => ['nullable', 'string', 'max:255'],
        ]);
        $categoria->update($datos);

        return back()->with('exito', 'Categoría actualizada.');
    }

    public function destroy(Categoria $categoria)
    {
        if ($categoria->documentos()->exists()) {
            return back()->with('error', 'No se puede eliminar una categoría que tiene documentos.');
        }
        $categoria->delete();

        return back()->with('exito', 'Categoría eliminada.');
    }
}
