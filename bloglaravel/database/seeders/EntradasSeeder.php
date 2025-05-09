<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Entrada;

class EntradasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Llamamos al factory para generar datos de prueba
        //El factory se encarga de crear los registros en la base de datos
        Entrada::factory(10)->create(); //Generamos 10 registros de prueba
    }
}
