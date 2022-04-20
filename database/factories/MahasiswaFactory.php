<?php

namespace Database\Factories;

use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

class MahasiswaFactory extends Factory
{
    protected $model = Mahasiswa::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'alamat' => $this->faker->address(),
            'nim' => $this->faker->unique()->numberBetween(1000000, 9999999),
            'tanggal_lahir' => $this->faker->date(),
        ];
    }
}
