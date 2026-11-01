<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consulta;
use App\Models\Documento;
use App\Models\Noticia;
use App\Models\Preinscripcion;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalDocumentos' => Documento::count(),
            'totalNoticias' => Noticia::where('publicada', true)->count(),
            'preinscripcionesPendientes' => Preinscripcion::where('estado', 'pendiente')->count(),
            'consultasPendientes' => Consulta::where('atendida', false)->count(),
            'ultimasPreinscripciones' => Preinscripcion::latest()->take(5)->get(),
            'ultimasConsultas' => Consulta::latest()->take(5)->get(),
        ]);
    }
}
