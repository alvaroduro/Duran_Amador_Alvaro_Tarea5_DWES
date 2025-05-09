<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;
use App\Models\User;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        // Crear categorias predeterminadas
        $categorias = ['Viajes','Estudios','Tecnología','Salud'];

        // Creamos los registros 
        foreach($categorias as $nombre) {
            Categoria::create(['nombre' => $nombre]);
        }
    }
}
