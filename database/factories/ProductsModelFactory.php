<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductsModel>
 */
class ProductsModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'price' => $this->faker->numberBetween(1, 1000),
            'stock' => $this->faker->numberBetween(10, 1000),
            'category' => $this->faker->randomElement(['makanan', 'minuman', 'snack']),
            'image' => $this->faker->imageUrl(),
        ];
    }
}
