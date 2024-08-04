<?php

namespace Tests\Feature;

use App\Models\Commande;
use App\Models\Client;
use App\Models\Produit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CommandeControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Création de clients et produits pour les tests
        Client::factory()->count(3)->create();
        Produit::factory()->count(3)->create();
    }

    /**
     * Test pour récupérer toutes les commandes.
     *
     * @return void
     */
    public function test_can_retrieve_all_commandes()
    {
        Commande::factory()->count(3)->create();

        $response = $this->getJson('/api/commandes');

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonStructure([
                     'message',
                     'data' => [
                         '*' => [
                             'id',
                             'client_id',
                             'produit_id',
                             'quantite',
                             'prix_total',
                             'created_at',
                             'updated_at'
                         ]
                     ]
                 ]);
    }

    /**
     * Test pour créer une nouvelle commande.
     *
     * @return void
     */
    public function test_can_create_a_commande()
    {
        $client = Client::first();
        $produit = Produit::first();
        $data = [
            'client_id' => $client->id,
            'produit_id' => $produit->id,
            'quantite' => 5,
            'prix_total' => 100.00,
        ];

        $response = $this->postJson('/api/commandes', $data);

        $response->assertStatus(Response::HTTP_CREATED)
                 ->assertJson([
                     'message' => 'Commande créée avec succès.',
                     'data' => $data
                 ]);
    }

    /**
     * Test pour afficher une commande spécifique.
     *
     * @return void
     */
    public function test_can_show_a_commande()
    {
        $commande = Commande::factory()->create();

        $response = $this->getJson("/api/commandes/{$commande->id}");

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJson([
                     'message' => 'Détails de la commande récupérés avec succès.',
                     'data' => $commande->toArray()
                 ]);
    }

    /**
     * Test pour mettre à jour une commande spécifique.
     *
     * @return void
     */
    public function test_can_update_a_commande()
    {
        $commande = Commande::factory()->create();
        $data = [
            'quantite' => 10,
            'prix_total' => 200.00,
        ];

        $response = $this->putJson("/api/commandes/{$commande->id}", $data);

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJson([
                     'message' => 'Commande mise à jour avec succès.',
                     'data' => array_merge($commande->toArray(), $data)
                 ]);
    }

    /**
     * Test pour supprimer une commande spécifique.
     *
     * @return void
     */
    public function test_can_delete_a_commande()
    {
        $commande = Commande::factory()->create();

        $response = $this->deleteJson("/api/commandes/{$commande->id}");

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJson([
                     'message' => 'Commande supprimée avec succès.'
                 ]);

        $this->assertDatabaseMissing('commandes', ['id' => $commande->id]);
    }
}
