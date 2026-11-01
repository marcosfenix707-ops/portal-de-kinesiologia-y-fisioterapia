<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Noticia extends Model
{
    protected $fillable = ['titulo', 'resumen', 'contenido', 'imagen', 'publicada', 'fecha_publicacion', 'user_id'];

    protected function casts(): array
    {
        return [
            'publicada' => 'boolean',
            'fecha_publicacion' => 'datetime',
        ];
    }

    public function autor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePublicadas(Builder $query): Builder
    {
        return $query->where('publicada', true)->orderByDesc('fecha_publicacion');
    }
}
