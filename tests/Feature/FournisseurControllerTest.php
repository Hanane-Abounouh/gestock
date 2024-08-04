<?php

namespace Tests\Feature;

use App\Models\Fournisseur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class FournisseurControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test pour récupérer tous les fournisseurs.
     *
     * @return void
     */
    public function test_can_retrieve_all_fournisseurs()
    {
        Fournisseur::factory()->count(3)->create();

        $response = $this->getJson('/api/fournisseurs');

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonStructure([
                     'message',
                     'data' => [
                         '*' => [
                             'id',
                             'nom',
                             'informations_contact',
                             'created_at',
                             'updated_at'
                         ]
                     ]
                 ]);
    }

    /**
     * Test pour créer un nouveau fournisseur.
     *
     * @return void
     */
    public function test_can_create_a_fournisseur()
    {
        $data = [
            'nom' => 'Fournisseur Test',
            'informations_contact' => 'Contact Info',
        ];

        $response = $this->postJson('/api/fournisseurs', $data);

        $response->assertStatus(Response::HTTP_CREATED)
                 ->assertJson([
                     'message' => 'Fournisseur créé avec succès.',
                     'data' => $data
                 ]);
    }

    /**
     * Test pour afficher un fournisseur spécifique.
     *
     * @return void
     */
    public function test_can_show_a_fournisseur()
    {
        $fournisseur = Fournisseur::factory()->create();

        $response = $this->getJson("/api/fournisseurs/{$fournisseur->id}");

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJson([
                     'message' => 'Détails du fournisseur récupérés avec succès.',
                     'data' => $fournisseur->toArray()
                 ]);
    }

    /**
     * Test pour mettre à jour un fournisseur spécifique.
     *
     * @return void
     */
    public function test_can_update_a_fournisseur()
    {
        $fournisseur = Fournisseur::factory()->create();
        $data = [
            'nom' => 'Fournisseur Mis à Jour',
            'informations_contact' => 'Updated Contact Info',
        ];

        $response = $this->putJson("/api/fournisseurs/{$fournisseur->id}", $data);

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJson([
                     'message' => 'Fournisseur mis à jour avec succès.',
                     'data' => array_merge($fournisseur->toArray(), $data)
                 ]);
    }

    /**
     * Test pour supprimer un fournisseur spécifique.
     *
     * @return void
     */
    public function test_can_delete_a_fournisseur()
    {
        $fournisseur = Fournisseur::factory()->create();

        $response = $this->deleteJson("/api/fournisseurs/{$fournisseur->id}");

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJson([
                     'message' => 'Fournisseur supprimé avec succès.'
                 ]);

        $this->assertDatabaseMissing('fournisseurs', ['id' => $fournisseur->id]);
    }
}
