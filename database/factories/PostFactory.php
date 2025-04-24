<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "titulo"=> $this->faker->sentence(5),  //genera un titulo aleatorio de 5 palabras
            "descripcion"=> $this->faker->sentence(20),    //genera un texto aleatorio de 20 palabras
            "imagen"=> $this->faker->uuid() . '.jpg',   //genera un uuid aleatorio que representa una imagen y le agrega el formato jpg
            "user_id"=> $this->faker->randomElement([5, 6, 7]), //genera un id de usuario aleatorio entre 1 y 3
        ];
    }
}
