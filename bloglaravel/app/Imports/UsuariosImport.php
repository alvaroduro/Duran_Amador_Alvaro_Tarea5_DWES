<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsuariosImport implements ToCollection, WithHeadingRow
{
    public $usuarios = [];

    public function collection(Collection $rows)
    {
        // Validar que las cabeceras esperadas existan
        if (!$rows->first()->has('nick') || 
        !$rows->first()->has('nombre') || 
        !$rows->first()->has('apellidos') || 
        !$rows->first()->has('avatar') ||
        !$rows->first()->has('rol') || 
        !$rows->first()->has('email') || 
        !$rows->first()->has('password')) {
            throw new \Exception('El archivo Excel debe tener las cabeceras: nick, nombre, apellidos, avatar, rol, email, password');
        }

        // Procesar cada fila
        foreach ($rows as $row) {
            if (isset($row['nombre'], $row['email'], $row['password'])) {
                $this->usuarios[] = [
                    'nick' => $row['nick'],
                    'nombre' => $row['nombre'],
                    'apellidos' => $row['apellidos'],
                    'avatar' => $row['avatar'],
                    'rol' => $row['rol'],
                    'email' => $row['email'],
                    'password' => (string) $row['password']
                ];
            }
        }
    }
}
