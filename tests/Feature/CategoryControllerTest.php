<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
    }

    /** @test */
    public function it_can_retrieve_all_categories()
    {
        $this->authenticate();
        
        Category::factory()->count(5)->create();

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200)
                  ->assertJsonCount(5);
    }

    /** @test */
    public function it_can_create_a_new_category()
    {
        $this->authenticate();

        $data = [
            'name' => 'New Category',
            'description' => 'Category description'
        ];

        $response = $this->postJson('/api/categories', $data);

        $response->assertStatus(201)
                  ->assertJson(['message' => 'La catégorie a été créée avec succès.']);
    }

    /** @test */
    public function it_can_show_a_category()
    {
        $this->authenticate();

        $category = Category::factory()->create();

        $response = $this->getJson('/api/categories/' . $category->id);

        $response->assertStatus(200)
                  ->assertJson(['name' => $category->name]);
    }

    /** @test */
    public function it_can_update_a_category()
    {
        $this->authenticate();

        $category = Category::factory()->create();

        $data = [
            'name' => 'Updated Category',
            'description' => 'Updated description'
        ];

        $response = $this->putJson('/api/categories/' . $category->id, $data);

        $response->assertStatus(200)
                  ->assertJson(['message' => 'La catégorie a été mise à jour avec succès.']);
    }

    /** @test */
    public function it_can_delete_a_category()
    {
        $this->authenticate();

        $category = Category::factory()->create();

        $response = $this->deleteJson('/api/categories/' . $category->id);

        $response->assertStatus(204);
    }
}
