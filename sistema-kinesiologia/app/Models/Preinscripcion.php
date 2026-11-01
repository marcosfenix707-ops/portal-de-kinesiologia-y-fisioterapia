<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preinscripcion extends Model
{
    protected $table = 'preinscripciones';

    protected $fillable = ['nombres', 'apellidos', 'correo', 'telefono', 'mensaje', 'estado'];
}
