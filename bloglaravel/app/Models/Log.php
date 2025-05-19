<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    // Nombre de la tabla (opcional si sigue la convención)
    protected $table = 'logs';

    // No timestamps si no usas updated_at (opcional)
    public $timestamps = false;

    // Campos que pueden ser asignados en masa
    protected $fillable = [
        'usuario',
        'operacion',
        'fecha',
        'hora',
    ];

    // Opcional: cast para created_at si lo usas como timestamp
    protected $casts = [
        'created_at' => 'datetime',
        'fecha' => 'date',
        'hora' => 'datetime',
    ];
}
