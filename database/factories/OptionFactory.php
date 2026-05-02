<?php

namespace Database\Factories;

use App\Models\Option;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Option>
 */
class OptionFactory extends Factory
{
    protected $model = Option::class;

    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'Balcon',
                'Terrasse',
                'Parking',
                'Garage',
                'Piscine',
                'Jardin',
                'Ascenseur',
                'Cuisine équipée',
                'Climatisation',
                'Chauffage individuel',
                'Proche transport',
                'Double vitrage',
            ]),
        ];
    }
}
