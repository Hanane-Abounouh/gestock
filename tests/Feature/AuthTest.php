<?php
// File: tests/Feature/AuthTest.php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles for the test
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'Admin'],
            ['id' => 2, 'name' => 'User'],
        ]);
    }

    /** @test */
    public function user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password123',
            // Remove role_id as it's set by default in the controller
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'token',
                     'user' => ['id', 'username', 'email', 'role_id']
                 ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'role_id' => 2,  // Default role_id
        ]);
    }

    /** @test */
    public function user_can_login()
    {
        $user = User::create([
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'role_id' => 2  // Ensure default role_id
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'token',
                     'user' => ['id', 'username', 'email', 'role_id']
                 ]);
    }

    /** @test */
    public function user_can_logout()
    {
        $user = User::create([
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'role_id' => 2  // Ensure default role_id
        ]);

        $token = $user->createToken('GeStockToken')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->postJson('/api/logout');

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Logged out successfully']);
    }
}
