<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Consulta;
use App\Models\Contenido;
use App\Models\Documento;
use App\Models\Noticia;
use App\Models\Preinscripcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicController extends Controller
{
    public function inicio()
    {
        return view('public.inicio', [
            'presentacion' => Contenido::porClave('presentacion'),
            'noticias' => Noticia::publicadas()->take(3)->get(),
            'documentos' => $this->documentosVisibles()->with('categoria')->latest()->take(5)->get(),
        ]);
    }

    public function carrera()
    {
        $orden = Contenido::orden();
        $contenidos = Contenido::whereIn('clave', $orden)->get()
            ->sortBy(fn ($c) => array_search($c->clave, $orden))->values();

        return view('public.carrera', compact('contenidos'));
    }

    public function seccion(Contenido $contenido)
    {
        abort_unless(in_array($contenido->clave, Contenido::orden(), true), 404);

        return view('public.seccion', compact('contenido'));
    }

    public function noticias()
    {
        return view('public.noticias', ['noticias' => Noticia::publicadas()->paginate(9)]);
    }

    public function noticia(Noticia $noticia)
    {
        abort_unless($noticia->publicada, 404);

        return view('public.noticia', compact('noticia'));
    }

    public function documentos(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $categoria = $request->integer('categoria');

        $documentos = $this->documentosVisibles()->with('categoria')
            ->when($q !== '', fn ($query) => $query->where(function ($w) use ($q) {
                $w->where('titulo', 'like', $this->like($q))->orWhere('descripcion', 'like', $this->like($q));
            }))
            ->when($categoria > 0, fn ($query) => $query->where('categoria_id', $categoria))
            ->orderByDesc('fecha_documento')->orderByDesc('created_at')
            ->paginate(10)->withQueryString();

        return view('public.documentos', [
            'documentos' => $documentos,
            'categorias' => Categoria::orderBy('nombre')->get(),
            'q' => $q,
            'categoria' => $categoria,
        ]);
    }

    public function documento(Documento $documento)
    {
        $this->autorizar($documento);

        return view('public.documento', compact('documento'));
    }

    public function archivo(Documento $documento)
    {
        $this->autorizar($documento);
        abort_unless(Storage::disk('local')->exists($documento->archivo), 404);

        if (! $documento->esPrevisualizable()) {
            return Storage::disk('local')->download($documento->archivo, $documento->nombre_original);
        }

        return Storage::disk('local')->response($documento->archivo, $documento->nombre_original, [
            'Content-Type' => $documento->mime,
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    public function descargar(Documento $documento)
    {
        $this->autorizar($documento);
        abort_unless(Storage::disk('local')->exists($documento->archivo), 404);

        return Storage::disk('local')->download($documento->archivo, $documento->nombre_original);
    }

    public function buscar(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $resultados = ['documentos' => collect(), 'noticias' => collect(), 'secciones' => collect()];

        if (mb_strlen($q) >= 2) {
            $like = $this->like($q);
            $resultados['documentos'] = $this->documentosVisibles()->with('categoria')
                ->where(fn ($w) => $w->where('titulo', 'like', $like)->orWhere('descripcion', 'like', $like))
                ->limit(20)->get();
            $resultados['noticias'] = Noticia::publicadas()
                ->where(fn ($w) => $w->where('titulo', 'like', $like)->orWhere('contenido', 'like', $like))
                ->limit(20)->get();
            $resultados['secciones'] = Contenido::whereIn('clave', Contenido::orden())
                ->where(fn ($w) => $w->where('titulo', 'like', $like)->orWhere('contenido', 'like', $like))
                ->limit(20)->get();
        }

        return view('public.buscar', compact('q', 'resultados'));
    }

    public function preinscripcion()
    {
        return view('public.preinscripcion');
    }

    public function guardarPreinscripcion(Request $request)
    {
        if ($request->filled('sitio_web')) { // campo trampa contra robots
            return redirect()->route('inicio');
        }

        $datos = $request->validate([
            'nombres' => ['required', 'string', 'max:100'],
            'apellidos' => ['required', 'string', 'max:100'],
            'correo' => ['required', 'email', 'max:150'],
            'telefono' => ['required', 'string', 'regex:/^[0-9+()\-\s]{6,30}$/'],
            'mensaje' => ['nullable', 'string', 'max:1000'],
        ]);

        Preinscripcion::create($datos);

        return redirect()->route('preinscripcion')
            ->with('exito', 'Su preinscripción fue registrada. La dirección de carrera se comunicará con usted.');
    }

    public function contacto()
    {
        return view('public.contacto');
    }

    public function guardarConsulta(Request $request)
    {
        if ($request->filled('sitio_web')) {
            return redirect()->route('inicio');
        }

        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:120'],
            'correo' => ['required', 'email', 'max:150'],
            'asunto' => ['required', 'string', 'max:150'],
            'mensaje' => ['required', 'string', 'max:2000'],
        ]);

        Consulta::create($datos);

        return redirect()->route('contacto')->with('exito', 'Su consulta fue enviada a la dirección de carrera.');
    }

    private function documentosVisibles()
    {
        return auth()->check() ? Documento::query() : Documento::publicos();
    }

    private function autorizar(Documento $documento): void
    {
        abort_unless($documento->publico || auth()->check(), 404);
    }

    private function like(string $texto): string
    {
        return '%'.addcslashes($texto, '%_\\').'%';
    }
}
