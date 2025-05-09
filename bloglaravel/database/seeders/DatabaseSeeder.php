<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\CategoriaFactory;
use Database\Factories\EntradaFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        //Creacion de usuarios
        User::factory()->create([
            'nick' => 'alvarito',
            'nombre' => 'Alvaro',
            'apellidos' => 'Duran Amador',
            'email' => 'alvaro@email.com',
            'password' => bcrypt('12345678'),
            'rol' => 'admin'
        ]);

        User::factory()->create([
            'nick' => 'sofi',
            'nombre' => 'Sofia',
            'apellidos' => 'Jimenez Amador',
            'email' => 'sofia@email.com',
            'password' => bcrypt('12345678'),
            'rol' => 'user'
        ]);

        $this->call([
            CategoriasSeeder::class,
            EntradasSeeder::class
        ]);
    }
}
