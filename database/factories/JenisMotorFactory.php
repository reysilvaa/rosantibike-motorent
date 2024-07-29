<?php

namespace Database\Factories;

use App\Models\JenisMotor;
use App\Models\Stok;
use Illuminate\Database\Eloquent\Factories\Factory;

class JenisMotorFactory extends Factory
{
    protected $model = JenisMotor::class;

    public function definition()
    {
        return [
            'id_stok' => Stok::factory(),
            'nopol' => strtoupper($this->faker->bothify('??###??')), // Example: AB123CD
            'status' => $this->faker->randomElement(['ready', 'disewa', 'perpanjang']),
        ];
    }
}
