<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $documentos = Documento::with(['categoria', 'usuario'])
            ->when($q !== '', fn ($query) => $query->where('titulo', 'like', '%'.addcslashes($q, '%_\\').'%'))
            ->latest()->paginate(15)->withQueryString();

        return view('admin.documentos.index', compact('documentos', 'q'));
    }

    public function create()
    {
        return view('admin.documentos.form', [
            'documento' => new Documento(['publico' => true]),
            'categorias' => Categoria::orderBy('nombre')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $datos = $request->validate($this->reglas(true));
        $archivo = $request->file('archivo');

        $meta = [
            'nombre_original' => $archivo->getClientOriginalName(),
            'mime' => $archivo->getMimeType() ?? 'application/octet-stream',
            'tamano' => $archivo->getSize(),
        ];
        $ruta = $archivo->store('documentos');

        Documento::create([
            'titulo' => $datos['titulo'],
            'descripcion' => $datos['descripcion'] ?? null,
            'categoria_id' => $datos['categoria_id'],
            'fecha_documento' => $datos['fecha_documento'] ?? null,
            'archivo' => $ruta,
            'user_id' => $request->user()->id,
            'publico' => $request->boolean('publico'),
        ] + $meta);

        return redirect()->route('admin.documentos.index')->with('exito', 'Documento guardado correctamente.');
    }

    public function edit(Documento $documento)
    {
        return view('admin.documentos.form', [
            'documento' => $documento,
            'categorias' => Categoria::orderBy('nombre')->get(),
        ]);
    }

    public function update(Request $request, Documento $documento)
    {
        $datos = $request->validate($this->reglas(false));

        $cambios = [
            'titulo' => $datos['titulo'],
            'descripcion' => $datos['descripcion'] ?? null,
            'categoria_id' => $datos['categoria_id'],
            'fecha_documento' => $datos['fecha_documento'] ?? null,
            'publico' => $request->boolean('publico'),
        ];

        if ($archivo = $request->file('archivo')) {
            $cambios['nombre_original'] = $archivo->getClientOriginalName();
            $cambios['mime'] = $archivo->getMimeType() ?? 'application/octet-stream';
            $cambios['tamano'] = $archivo->getSize();
            $nuevo = $archivo->store('documentos');
            Storage::disk('local')->delete($documento->archivo);
            $cambios['archivo'] = $nuevo;
        }

        $documento->update($cambios);

        return redirect()->route('admin.documentos.index')->with('exito', 'Documento actualizado.');
    }

    public function destroy(Documento $documento)
    {
        Storage::disk('local')->delete($documento->archivo);
        $documento->delete();

        return redirect()->route('admin.documentos.index')->with('exito', 'Documento eliminado.');
    }

    private function reglas(bool $crear): array
    {
        return [
            'titulo' => ['required', 'string', 'max:200'],
            'descripcion' => ['nullable', 'string', 'max:1000'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'fecha_documento' => ['nullable', 'date'],
            'archivo' => [$crear ? 'required' : 'nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png', 'max:20480'],
        ];
    }
}
