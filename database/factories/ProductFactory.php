<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->words(2, true);

        return [
            'category_id' => 1,
            'name' => $name,
            'slug' => Str::slug($name) . '-' . rand(1000, 9999), // ✅ يولّد slug فريد
            'description' => $this->faker->sentence(8),
            'price' => $this->faker->randomFloat(2, 50, 500),
            'sale_price' => $this->faker->randomFloat(2, 30, 400),
            'stock' => $this->faker->numberBetween(10, 100),
            'image' => 'https://picsum.photos/600/600?random=' . rand(1, 1000),
        ];
    }
}
