<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->string('archivo');
            $table->string('nombre_original');
            $table->string('mime', 150);
            $table->unsignedBigInteger('tamano');
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->foreignId('user_id')->constrained('users');
            $table->boolean('publico')->default(true);
            $table->date('fecha_documento')->nullable();
            $table->timestamps();
            $table->index('titulo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
