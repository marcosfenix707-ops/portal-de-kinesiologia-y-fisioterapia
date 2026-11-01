<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contenido extends Model
{
    protected $fillable = ['clave', 'titulo', 'contenido', 'user_id'];

    /** Orden en que se muestran las secciones de "La carrera". */
    public static function orden(): array
    {
        return ['mision', 'vision', 'objetivos', 'perfil_profesional', 'campo_ocupacional',
            'modalidades_admision', 'modalidades_titulacion', 'plan_estudios', 'carga_horaria',
            'plantel_docente', 'horarios', 'estructura_organizativa'];
    }

    public static function porClave(string $clave): ?self
    {
        return static::where('clave', $clave)->first();
    }
}
