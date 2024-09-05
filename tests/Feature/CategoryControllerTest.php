<?php
namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Authenticate a user
        $this->actingAs(User::factory()->create(), 'sanctum');
    }

    /** @test */
    public function it_can_list_all_categories()
    {
        $categories = Category::factory(3)->create();

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    /** @test */
    public function it_can_create_a_category()
    {
        $data = [
            'name' => 'New Category',
            'description' => 'A new category description', // Ensure this field is allowed
        ];

        $response = $this->postJson('/api/categories', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['name' => 'New Category']);
                 
        $this->assertDatabaseHas('categories', ['name' => 'New Category']);
    }

    /** @test */
    public function it_can_show_a_category()
    {
        $category = Category::factory()->create();

        $response = $this->getJson("/api/categories/{$category->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => $category->name]);
    }

    /** @test */
    public function it_can_update_a_category()
    {
        $category = Category::factory()->create();

        $data = ['name' => 'Updated Category Name'];

        $response = $this->putJson("/api/categories/{$category->id}", $data);

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Updated Category Name']);
                 
        $this->assertDatabaseHas('categories', ['name' => 'Updated Category Name']);
    }

    /** @test */
    public function it_can_delete_a_category()
    {
        $category = Category::factory()->create();

        $response = $this->deleteJson("/api/categories/{$category->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    /** @test */
    public function it_validates_name_when_creating_a_category()
    {
        $data = [
            'description' => 'This category has no name',
        ];

        $response = $this->postJson('/api/categories', $data);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors('name');
    }

    /** @test */
    public function it_validates_name_when_updating_a_category()
    {
        $category = Category::factory()->create();

        $data = [
            'name' => '', // Validate empty name
        ];

        $response = $this->putJson("/api/categories/{$category->id}", $data);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors('name');
    }
}
