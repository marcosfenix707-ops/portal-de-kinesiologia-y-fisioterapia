<?php

return [
    'required' => 'El campo :attribute es obligatorio.',
    'email' => 'El campo :attribute debe ser un correo electrónico válido.',
    'string' => 'El campo :attribute debe ser texto.',
    'confirmed' => 'La confirmación de :attribute no coincide.',
    'unique' => 'El valor de :attribute ya está registrado.',
    'exists' => 'El valor seleccionado en :attribute no es válido.',
    'boolean' => 'El campo :attribute debe ser verdadero o falso.',
    'date' => 'El campo :attribute no es una fecha válida.',
    'image' => 'El campo :attribute debe ser una imagen.',
    'file' => 'El campo :attribute debe ser un archivo.',
    'mimes' => 'El campo :attribute debe ser un archivo de tipo: :values.',
    'in' => 'El valor seleccionado en :attribute no es válido.',
    'regex' => 'El formato de :attribute no es válido.',
    'max' => [
        'string' => 'El campo :attribute no debe superar :max caracteres.',
        'file' => 'El archivo :attribute no debe superar :max kilobytes.',
    ],
    'min' => [
        'string' => 'El campo :attribute debe tener al menos :min caracteres.',
    ],
    'attributes' => [
        'titulo' => 'título', 'descripcion' => 'descripción', 'archivo' => 'archivo', 'categoria_id' => 'categoría',
        'nombre' => 'nombre', 'nombres' => 'nombres', 'apellidos' => 'apellidos', 'correo' => 'correo',
        'telefono' => 'teléfono', 'mensaje' => 'mensaje', 'asunto' => 'asunto', 'contenido' => 'contenido',
        'resumen' => 'resumen', 'imagen' => 'imagen', 'password' => 'contraseña', 'email' => 'correo',
        'name' => 'nombre', 'role_id' => 'rol', 'estado' => 'estado', 'fecha_documento' => 'fecha del documento',
    ],
];
