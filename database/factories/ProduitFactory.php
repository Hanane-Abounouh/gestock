<?php

namespace Database\Factories;

use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Fournisseur;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProduitFactory extends Factory
{
    protected $model = Produit::class;

    public function definition()
    {
        return [
            'nom' => $this->faker->word,
            'categorie_id' => Categorie::factory(),
            'fournisseur_id' => Fournisseur::factory(),
            'quantite' => $this->faker->numberBetween(1, 100),
            'prix' => $this->faker->randomFloat(2, 1, 1000),
        ];
    }
}
