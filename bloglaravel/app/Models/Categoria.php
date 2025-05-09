<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    /** @use HasFactory<\Database\Factories\CategoriaFactory> */
    use HasFactory;

    // Permitimos la inserciion masiva
    protected $fillable = [
        'nombre'
    ];

    // Definir la relación inversa
    public function entradas()
    {
        return $this->hasMany(Entrada::class, 'categoria_id');//relaciones
    }
}
