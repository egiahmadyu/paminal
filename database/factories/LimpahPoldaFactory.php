<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LimpahPolda>
 */
class LimpahPoldaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'data_pelanggar_id' => fake()->randomNumber(),
            'polda_id' => fake()->randomNumber(),
            'tanggal_limpah' => fake()->date(),
            'created_by' => fake()->name(),
        ];
    }
}
