<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MangaFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->sentence(3); // contoh nama acak

        return [
            'title' => $title,
            'description' => $this->faker->text(50, 100),
            'author' => $this->faker->name(),
            'artist' => $this->faker->name(),
            'cover_image' => 'covers/naruto.png', // bisa dibuat random jika punya asset list
            'status' => $this->faker->randomElement(['Ongoing','Completed']),
            'rating' => $this->faker->randomFloat(1, 6, 10), // rating 6.0 - 10.0
            'views' => $this->faker->numberBetween(100, 2000),
        ];
    }
}
