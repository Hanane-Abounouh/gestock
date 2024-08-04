<?php

namespace Database\Factories;

use App\Models\CommandeItem;
use App\Models\Commande;
use App\Models\Produit;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommandeItemFactory extends Factory
{
    protected $model = CommandeItem::class;

    public function definition()
    {
        return [
            'commande_id' => Commande::factory(), // Assure que la commande existe
            'produit_id' => Produit::factory(),   // Assure que le produit existe
            'quantite' => $this->faker->numberBetween(1, 10),
            'prix' => $this->faker->randomFloat(2, 1, 100),
        ];
    }
}
