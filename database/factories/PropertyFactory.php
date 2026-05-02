<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        $type = $this->faker->randomElement(['Appartement', 'Maison', 'Villa', 'Studio', 'Loft', 'Duplex', 'Penthouse', 'Chalet', 'Ferme', 'Manoir', 'Bungalow', 'Cottage', 'Résidence', 'Immeuble', 'Local commercial']);
        $name = $this->faker->lastName();
        $surface = $this->faker->numberBetween(30, 350);
        $rooms = $this->faker->numberBetween(1, 18);
        $bedrooms = $this->faker->numberBetween(0, min($rooms, 15));
        $price = $this->faker->numberBetween(50000, 1500000);
        $city = $this->faker->city();

        return [
            'title' => "{$type} {$name} à {$city}",
            'description' => "Bel appartement de {$surface}m² avec {$rooms} pièces dont {$bedrooms} chambres, situé à {$city}, vendu au prix de {$price}€. Idéal pour famille ou investissement.",
            'surface' => $surface,
            'rooms' => $rooms,
            'bedrooms' => $bedrooms,
            'floor' => $this->faker->numberBetween(0, 10),
            'price' => $price,
            'city' => $city,
            'address' => $this->faker->streetAddress(),
            'postal_code' => $this->faker->postcode(),
            'sold' => false,
            'user_id' => 1,
        ];
    }

    public function sold(): static
    {
        return $this->state(fn (array $attributes) => [
            'sold' => true,
        ]);
    }
}
