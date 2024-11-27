<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MetricHistoryRun>
 */
class MetricHistoryRunFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'url' => fake()->url(),
            'accesibility_metric' => (fake()->numberBetween(0,100)) / 100,
            'pwa_metric' => 0,
            'performance_metric' => (fake()->numberBetween(0,100)) / 100,
            'seo_metric' => (fake()->numberBetween(0,100)) / 100,
            'best_practices_metric' => (fake()->numberBetween(0,100)) / 100
        ];
    }
}
