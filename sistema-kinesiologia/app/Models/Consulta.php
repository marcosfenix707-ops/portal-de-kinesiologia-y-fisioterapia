<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    protected $fillable = ['nombre', 'correo', 'asunto', 'mensaje', 'atendida'];

    protected function casts(): array
    {
        return ['atendida' => 'boolean'];
    }
}
