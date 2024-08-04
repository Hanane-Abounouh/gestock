<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition()
    {
        return [
            'nom' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'telephone' => $this->faker->phoneNumber,
            'adresse' => $this->faker->address,
        ];
    }
}
