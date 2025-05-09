<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('entradas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('slug')
                ->unique(); //Ruta amigable

            $table->text('descripcion')
                ->nullable(); //Descripción corta

            $table->string('imagen')->nullable(); //Ruta imagen del post

            // Foreign key para la relación con la tabla de usuarios
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            // Foreign key para la relación con la tabla de categorias
            $table->foreignId('categoria_id')
                ->constrained()
                ->onDelete('cascade');

            $table->timestamp('fecha_publicacion')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entradas');
    }
};
