<?php

namespace Database\Factories;

use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(100000, 1000000),
            'region_id' => Region::factory(),
            'type' => $this->faker->randomElement(['rent', 'sale']),
            'location' => $this->faker->address(),
            'status' => $this->faker->randomElement(['available', 'pending', 'sold']),
            'featured_image' => null,
        ];
    }
}
