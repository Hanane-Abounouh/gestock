<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Ajouter les rôles par défaut dans la base de données de test
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
    }

    /** @test */
    public function it_can_register_a_new_user()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(['message', 'user' => ['id', 'name', 'email', 'role_id']]);
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    /** @test */
    public function it_can_login_an_existing_user()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['message', 'token', 'user']);
    }

    /** @test */
    public function it_can_logout_a_user()
    {
        $user = User::factory()->create();
        $token = $user->createToken('GeStockToken')->plainTextToken;

        Sanctum::actingAs($user, ['*']);

        $response = $this->postJson('/api/logout', [
            'tokenId' => $user->tokens->first()->id,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Logout successful.']);
    }
}
