<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DataPelanggar>
 */
class DataPelanggarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'no_nota_dinas' => fake()->regexify(),
            'no_pengaduan' => fake()->regexify(),
            'pelapor' => fake()->name(),
            'terlapor' => fake()->name(),
            'pangkat' => fake()->jobTitle(),
            'nrp' => fake()->randomNumber(),
            'wujud' => fake()->randomElement(['foto','barang']),
            'polda' => fake()->randomElement(['metro jaya','jabar','jateng','jatim','banten','bali']),
            'status' => fake()->randomElement([0,1]),
            'tanggal' => fake()->date(),
        ];
    }
}
