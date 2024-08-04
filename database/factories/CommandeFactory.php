<?php

namespace Database\Factories;

use App\Models\Commande;
use App\Models\Client;
use App\Models\Produit;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommandeFactory extends Factory
{
    protected $model = Commande::class;

    public function definition()
    {
        return [
            'client_id' => Client::factory(), // Assurez-vous que les clients sont générés correctement
            'produit_id' => Produit::factory(), // Assurez-vous que les produits sont générés correctement
            'quantite' => $this->faker->numberBetween(1, 10),
            'prix_total' => $this->faker->randomFloat(2, 10, 100),
        ];
    }
}
