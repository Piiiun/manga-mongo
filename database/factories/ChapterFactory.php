<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ChapterFactory extends Factory
{
    public function definition(): array
    {
        return [
            'number' => $this->faker->numberBetween(1,200),
            'slug' => $this->faker->numberBetween(1,200),
            'title' => 'Chapter '.$this->faker->numberBetween(1,200),
            'created_at' => $this->faker->dateTimeBetween('-1 years', 'now'),
        ];
    }
}
