<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Categoria;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entrada>
 */
class EntradaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        //Creacion tabla posts
        return [
            'titulo' => $this->faker->sentence(),
            'slug' => $this->faker->unique()->slug,
            'descripcion' => $this->faker->text(200),
            'imagen' => null, 
            'user_id' => User::all()->random()->id, //user_id aleatorio
            'categoria_id' => Categoria::all()->random()->id, //categoria_id aleatorio 
            'fecha_publicacion' => now(),
        ];
    }
}
