<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MedicineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'is_available' => true,
            'description' => $this->faker->text(100),
            'thumbnail' => $this->faker->image(),
        ];
    }
}
