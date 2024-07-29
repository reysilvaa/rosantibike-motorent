<?php

namespace Database\Factories;

use App\Models\Stok;
use Illuminate\Database\Eloquent\Factories\Factory;

class StokFactory extends Factory
{
    protected $model = Stok::class;

    private static $index = 0;

    public function definition()
    {
        // Arrays of fixed values
        $merks = ['Honda', 'Yamaha', 'Suzuki', 'Kawasaki', 'Ducati'];
        $prices = [100, 150, 200, 250, 300]; // Different fixed prices
        $photos = [
            'https://example.com/image1.jpg',
            'https://example.com/image2.jpg',
            'https://example.com/image3.jpg',
        ];

        // Calculate the index for the current record
        $index = self::$index % count($merks);
        self::$index++;

        return [
            'merk' => $merks[$index], // Sequentially use 'merk'
            'harga_perHari' => $this->faker->randomElement($prices), // Random price from the array
            'foto' => $photos[2], // Fixed image URL
        ];
    }
}
