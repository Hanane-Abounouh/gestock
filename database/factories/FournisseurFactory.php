<?php

namespace Database\Factories;

use App\Models\Fournisseur;
use Illuminate\Database\Eloquent\Factories\Factory;

class FournisseurFactory extends Factory
{
    protected $model = Fournisseur::class;

    public function definition()
    {
        return [
            'nom' => $this->faker->company,
            'informations_contact' => $this->faker->optional()->text,
        ];
    }
}
