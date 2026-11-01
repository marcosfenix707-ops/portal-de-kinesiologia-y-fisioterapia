<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Documento extends Model
{
    protected $fillable = [
        'titulo', 'descripcion', 'archivo', 'nombre_original', 'mime', 'tamano',
        'categoria_id', 'user_id', 'publico', 'fecha_documento',
    ];

    protected function casts(): array
    {
        return [
            'publico' => 'boolean',
            'fecha_documento' => 'date',
        ];
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePublicos(Builder $query): Builder
    {
        return $query->where('publico', true);
    }

    public function esPrevisualizable(): bool
    {
        return in_array($this->mime, ['application/pdf', 'image/jpeg', 'image/png'], true);
    }

    public function tamanoLegible(): string
    {
        $bytes = (int) $this->tamano;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 1).' MB';
        }

        return number_format(max($bytes, 1) / 1024, 0).' KB';
    }
}
