<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    /** @use HasFactory<\Database\Factories\EntradaFactory> */
    use HasFactory;


    // Registros masivos
    protected $fillable = [
        'titulo',
        'slug',
        'descripcion',
        'imagen',
        'user_id',
        'categoria_id',
        'fecha_publicacion'
    ];

    //casteamos los posibles campos
    protected $casts = [
        'fecha_publicacion' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id'); // Dependencias
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id'); // Dependencias
    }
}
