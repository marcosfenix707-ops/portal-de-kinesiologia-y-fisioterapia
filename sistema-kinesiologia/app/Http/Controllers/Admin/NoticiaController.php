<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NoticiaController extends Controller
{
    public function index()
    {
        return view('admin.noticias.index', ['noticias' => Noticia::with('autor')->latest()->paginate(15)]);
    }

    public function create()
    {
        return view('admin.noticias.form', ['noticia' => new Noticia(['publicada' => true])]);
    }

    public function store(Request $request)
    {
        $datos = $request->validate($this->reglas());
        $publicada = $request->boolean('publicada');

        Noticia::create([
            'titulo' => $datos['titulo'],
            'resumen' => $datos['resumen'] ?? null,
            'contenido' => $datos['contenido'],
            'imagen' => $request->hasFile('imagen') ? $request->file('imagen')->store('noticias', 'public') : null,
            'publicada' => $publicada,
            'fecha_publicacion' => $publicada ? now() : null,
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('admin.noticias.index')->with('exito', 'Noticia guardada.');
    }

    public function edit(Noticia $noticia)
    {
        return view('admin.noticias.form', compact('noticia'));
    }

    public function update(Request $request, Noticia $noticia)
    {
        $datos = $request->validate($this->reglas());
        $publicada = $request->boolean('publicada');

        $cambios = [
            'titulo' => $datos['titulo'],
            'resumen' => $datos['resumen'] ?? null,
            'contenido' => $datos['contenido'],
            'publicada' => $publicada,
            'fecha_publicacion' => $publicada ? ($noticia->fecha_publicacion ?? now()) : null,
        ];

        if ($request->hasFile('imagen')) {
            if ($noticia->imagen) {
                Storage::disk('public')->delete($noticia->imagen);
            }
            $cambios['imagen'] = $request->file('imagen')->store('noticias', 'public');
        }

        $noticia->update($cambios);

        return redirect()->route('admin.noticias.index')->with('exito', 'Noticia actualizada.');
    }

    public function destroy(Noticia $noticia)
    {
        if ($noticia->imagen) {
            Storage::disk('public')->delete($noticia->imagen);
        }
        $noticia->delete();

        return redirect()->route('admin.noticias.index')->with('exito', 'Noticia eliminada.');
    }

    private function reglas(): array
    {
        return [
            'titulo' => ['required', 'string', 'max:200'],
            'resumen' => ['nullable', 'string', 'max:500'],
            'contenido' => ['required', 'string', 'max:20000'],
            'imagen' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}
