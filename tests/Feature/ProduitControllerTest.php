<?php

namespace Tests\Feature;

use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Fournisseur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class ProduitControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Création de catégories et fournisseurs pour les tests
        Categorie::factory()->count(3)->create();
        Fournisseur::factory()->count(3)->create();
    }

    /**
     * Test pour récupérer tous les produits.
     *
     * @return void
     */
    public function test_can_retrieve_all_produits()
    {
        Produit::factory()->count(3)->create();

        $response = $this->getJson('/api/produits');

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonStructure([
                     'message',
                     'data' => [
                         '*' => [
                             'id',
                             'nom',
                             'categorie_id',
                             'fournisseur_id',
                             'quantite',
                             'prix',
                             'created_at',
                             'updated_at'
                         ]
                     ]
                 ]);
    }

    /**
     * Test pour créer un nouveau produit.
     *
     * @return void
     */
    public function test_can_create_a_produit()
    {
        $categorie = Categorie::first();
        $fournisseur = Fournisseur::first();
        $data = [
            'nom' => 'Produit Test',
            'categorie_id' => $categorie->id,
            'fournisseur_id' => $fournisseur->id,
            'quantite' => 10,
            'prix' => 20.50,
        ];

        $response = $this->postJson('/api/produits', $data);

        $response->assertStatus(Response::HTTP_CREATED)
                 ->assertJson([
                     'message' => 'Produit créé avec succès.',
                     'data' => $data
                 ]);
    }

    /**
     * Test pour afficher un produit spécifique.
     *
     * @return void
     */
    public function test_can_show_a_produit()
    {
        $produit = Produit::factory()->create();

        $response = $this->getJson("/api/produits/{$produit->id}");

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJson([
                     'message' => 'Détails du produit récupérés avec succès.',
                     'data' => $produit->toArray()
                 ]);
    }

    /**
     * Test pour mettre à jour un produit spécifique.
     *
     * @return void
     */
    public function test_can_update_a_produit()
    {
        $produit = Produit::factory()->create();
        $data = [
            'nom' => 'Produit Mis à Jour',
            'quantite' => 15,
            'prix' => 25.75,
        ];

        $response = $this->putJson("/api/produits/{$produit->id}", $data);

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJson([
                     'message' => 'Produit mis à jour avec succès.',
                     'data' => array_merge($produit->toArray(), $data)
                 ]);
    }

    /**
     * Test pour supprimer un produit spécifique.
     *
     * @return void
     */
    public function test_can_delete_a_produit()
    {
        $produit = Produit::factory()->create();

        $response = $this->deleteJson("/api/produits/{$produit->id}");

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJson([
                     'message' => 'Produit supprimé avec succès.'
                 ]);

        $this->assertDatabaseMissing('produits', ['id' => $produit->id]);
    }
}
