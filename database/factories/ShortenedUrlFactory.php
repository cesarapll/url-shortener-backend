<?php

namespace Database\Factories;

use App\Models\ShortenedUrl;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShortenedUrl>
 */
class ShortenedUrlFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            "code" => $this->faker->lexify('????????'),
            "original_url" => $this->faker->url
        ];
    }
}
