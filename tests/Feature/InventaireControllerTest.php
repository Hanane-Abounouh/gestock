<?php

namespace Tests\Feature;

use App\Models\Inventaire;
use App\Models\Produit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class InventaireControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test pour récupérer tous les inventaires.
     *
     * @return void
     */
    public function test_can_retrieve_all_inventaires()
    {
        Inventaire::factory()->count(3)->create();

        $response = $this->getJson('/api/inventaires');

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonStructure([
                     'message',
                     'data' => [
                         '*' => [
                             'id',
                             'produit_id',
                             'quantite',
                             'location',
                             'capacity',
                             'currentStock',
                             'created_at',
                             'updated_at',
                             'produit' => [
                                 'id',
                                 // Autres attributs de produit si nécessaire
                             ]
                         ]
                     ]
                 ]);
    }

    /**
     * Test pour créer un nouvel inventaire.
     *
     * @return void
     */
    public function test_can_create_an_inventaire()
    {
        $produit = Produit::factory()->create();

        $data = [
            'produit_id' => $produit->id,
            'quantite' => 50,
            'location' => 'A1',
            'capacity' => 200,
            'currentStock' => 150,
        ];

        $response = $this->postJson('/api/inventaires', $data);

        $response->assertStatus(Response::HTTP_CREATED)
                 ->assertJson([
                     'message' => 'Inventaire créé avec succès',
                     'data' => $data
                 ]);
    }

    /**
     * Test pour afficher un inventaire spécifique.
     *
     * @return void
     */
    public function test_can_show_an_inventaire()
    {
        $inventaire = Inventaire::factory()->create();

        $response = $this->getJson("/api/inventaires/{$inventaire->id}");

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJson([
                     'message' => 'Inventaire récupéré avec succès',
                     'data' => $inventaire->toArray()
                 ]);
    }

    /**
     * Test pour mettre à jour un inventaire spécifique.
     *
     * @return void
     */
    public function test_can_update_an_inventaire()
    {
        $inventaire = Inventaire::factory()->create();
        $data = [
            'produit_id' => $inventaire->produit_id,
            'quantite' => 75,
            'location' => 'B2',
            'capacity' => 300,
            'currentStock' => 225,
        ];

        $response = $this->putJson("/api/inventaires/{$inventaire->id}", $data);

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJson([
                     'message' => 'Inventaire mis à jour avec succès',
                     'data' => array_merge($inventaire->toArray(), $data)
                 ]);
    }

    /**
     * Test pour supprimer un inventaire spécifique.
     *
     * @return void
     */
    public function test_can_delete_an_inventaire()
    {
        $inventaire = Inventaire::factory()->create();

        $response = $this->deleteJson("/api/inventaires/{$inventaire->id}");

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('inventaires', ['id' => $inventaire->id]);
    }
}
