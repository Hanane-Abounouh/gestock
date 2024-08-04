<?php

namespace Tests\Feature;

use App\Models\CommandeItem;
use App\Models\Commande;
use App\Models\Produit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CommandeItemControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test pour récupérer tous les éléments de commande.
     *
     * @return void
     */
    public function test_can_retrieve_all_commande_items()
    {
        CommandeItem::factory()->count(3)->create();

        $response = $this->getJson('/api/commande-items');

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonStructure([
                     'message',
                     'data' => [
                         '*' => [
                             'id',
                             'commande_id',
                             'produit_id',
                             'quantite',
                             'prix',
                             'created_at',
                             'updated_at',
                             'commande' => [
                                 'id',
                                 // Autres attributs de commande si nécessaire
                             ],
                             'produit' => [
                                 'id',
                                 // Autres attributs de produit si nécessaire
                             ]
                         ]
                     ]
                 ]);
    }

    /**
     * Test pour créer un nouvel élément de commande.
     *
     * @return void
     */
    public function test_can_create_a_commande_item()
    {
        $commande = Commande::factory()->create();
        $produit = Produit::factory()->create();

        $data = [
            'commande_id' => $commande->id,
            'produit_id' => $produit->id,
            'quantite' => 5,
            'prix' => 100.50,
        ];

        $response = $this->postJson('/api/commande-items', $data);

        $response->assertStatus(Response::HTTP_CREATED)
                 ->assertJson([
                     'message' => 'Élément de commande créé avec succès.',
                     'data' => $data
                 ]);
    }

    /**
     * Test pour afficher un élément de commande spécifique.
     *
     * @return void
     */
    public function test_can_show_a_commande_item()
    {
        $commandeItem = CommandeItem::factory()->create();

        $response = $this->getJson("/api/commande-items/{$commandeItem->id}");

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJson([
                     'message' => 'Détails de l\'élément de commande récupérés avec succès.',
                     'data' => $commandeItem->toArray()
                 ]);
    }

    /**
     * Test pour mettre à jour un élément de commande spécifique.
     *
     * @return void
     */
    public function test_can_update_a_commande_item()
    {
        $commandeItem = CommandeItem::factory()->create();
        $data = [
            'commande_id' => $commandeItem->commande_id,
            'produit_id' => $commandeItem->produit_id,
            'quantite' => 10,
            'prix' => 200.75,
        ];

        $response = $this->putJson("/api/commande-items/{$commandeItem->id}", $data);

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJson([
                     'message' => 'Élément de commande mis à jour avec succès.',
                     'data' => array_merge($commandeItem->toArray(), $data)
                 ]);
    }

    /**
     * Test pour supprimer un élément de commande spécifique.
     *
     * @return void
     */
    public function test_can_delete_a_commande_item()
    {
        $commandeItem = CommandeItem::factory()->create();

        $response = $this->deleteJson("/api/commande-items/{$commandeItem->id}");

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJson([
                     'message' => 'Élément de commande supprimé avec succès.'
                 ]);

        $this->assertDatabaseMissing('commande_items', ['id' => $commandeItem->id]);
    }
}
