<?php

namespace Tests\Feature;

use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class ClientControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_all_clients()
    {
        // Crée plusieurs clients
        $clients = Client::factory()->count(3)->create();

        // Effectue une requête GET pour récupérer tous les clients
        $response = $this->getJson('/api/clients');

        // Vérifie que la réponse a le code de statut 200 et contient les clients
        $response->assertStatus(Response::HTTP_OK)
                 ->assertJson([
                     'message' => 'Liste de tous les clients récupérée avec succès.',
                     'data' => $clients->toArray()
                 ]);
    }

    /** @test */
    public function it_can_create_a_client()
    {
        $data = [
            'nom' => 'John Doe',
            'email' => 'john.doe@example.com',
            'telephone' => '1234567890',
            'adresse' => '123 Main St',
        ];

        // Effectue une requête POST pour créer un nouveau client
        $response = $this->postJson('/api/clients', $data);

        // Vérifie que la réponse a le code de statut 201 et contient le client créé
        $response->assertStatus(Response::HTTP_CREATED)
                 ->assertJson([
                     'message' => 'Client créé avec succès.',
                     'data' => $data
                 ]);
    }

    /** @test */
    public function it_can_show_a_client()
    {
        // Crée un client
        $client = Client::factory()->create();

        // Effectue une requête GET pour récupérer les détails du client
        $response = $this->getJson("/api/clients/{$client->id}");

        // Vérifie que la réponse a le code de statut 200 et contient les détails du client
        $response->assertStatus(Response::HTTP_OK)
                 ->assertJson([
                     'message' => 'Détails du client récupérés avec succès.',
                     'data' => $client->toArray()
                 ]);
    }

    /** @test */
    public function it_can_update_a_client()
    {
        // Crée un client
        $client = Client::factory()->create();

        // Données de mise à jour
        $data = [
            'nom' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'telephone' => '0987654321',
            'adresse' => '456 Elm St',
        ];

        // Effectue une requête PUT pour mettre à jour le client
        $response = $this->putJson("/api/clients/{$client->id}", $data);

        // Vérifie que la réponse a le code de statut 200 et contient le client mis à jour
        $response->assertStatus(Response::HTTP_OK)
                 ->assertJson([
                     'message' => 'Client mis à jour avec succès.',
                     'data' => array_merge($client->toArray(), $data)
                 ]);
    }

    /** @test */
    public function it_can_delete_a_client()
    {
        // Crée un client
        $client = Client::factory()->create();

        // Effectue une requête DELETE pour supprimer le client
        $response = $this->deleteJson("/api/clients/{$client->id}");

        // Vérifie que la réponse a le code de statut 200 et que le client a été supprimé
        $response->assertStatus(Response::HTTP_OK)
                 ->assertJson([
                     'message' => 'Client supprimé avec succès.'
                 ]);

        // Vérifie que le client a été supprimé de la base de données
        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }
}
