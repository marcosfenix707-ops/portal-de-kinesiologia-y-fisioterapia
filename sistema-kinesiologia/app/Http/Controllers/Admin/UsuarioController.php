<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    public function index()
    {
        return view('admin.usuarios.index', ['usuarios' => User::with('role')->orderBy('name')->get()]);
    }

    public function create()
    {
        return view('admin.usuarios.form', ['usuario' => new User(['activo' => true]), 'roles' => Role::orderBy('nombre')->get()]);
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);
        User::create($datos + ['activo' => $request->boolean('activo')]);

        return redirect()->route('admin.usuarios.index')->with('exito', 'Usuario creado.');
    }

    public function edit(User $usuario)
    {
        return view('admin.usuarios.form', ['usuario' => $usuario, 'roles' => Role::orderBy('nombre')->get()]);
    }

    public function update(Request $request, User $usuario)
    {
        $datos = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($usuario->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        if (empty($datos['password'])) {
            unset($datos['password']);
        }

        $activo = $request->boolean('activo');
        if ($usuario->id === $request->user()->id) {
            $activo = true; // no puede desactivarse a sí mismo
        }

        $usuario->update($datos + ['activo' => $activo]);

        return redirect()->route('admin.usuarios.index')->with('exito', 'Usuario actualizado.');
    }

    public function destroy(Request $request, User $usuario)
    {
        if ($usuario->id === $request->user()->id) {
            return back()->with('error', 'No puede eliminar su propio usuario.');
        }

        try {
            $usuario->delete();
        } catch (QueryException) {
            return back()->with('error', 'No se puede eliminar: el usuario tiene contenido asociado. Desactívelo en su lugar.');
        }

        return back()->with('exito', 'Usuario eliminado.');
    }
}
