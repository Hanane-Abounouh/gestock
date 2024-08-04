<?php

namespace Database\Factories;

use App\Models\Inventaire;
use App\Models\Produit;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventaireFactory extends Factory
{
    protected $model = Inventaire::class;

    public function definition()
    {
        return [
            'produit_id' => Produit::factory(), // Assure que le produit existe
            'quantite' => $this->faker->numberBetween(1, 100),
            'location' => $this->faker->word,
            'capacity' => $this->faker->numberBetween(1, 1000),
            'currentStock' => $this->faker->numberBetween(0, 1000),
        ];
    }
}
