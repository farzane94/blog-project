<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use refreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_valid_password(): void
    {
        $user = User::factory()->create([
            'mobile' => '09191234567',
            'password' => bcrypt('password123')
        ]);

        $response = $this->postJson('/api/auth/login', [
            'mobile' => '09191234567',
            'password' => 'password123'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => ['access_token', 'token_type', 'expires_in'],
                'server_time'
            ]);
    }

    public function test_invalid_password(): void
    {
        $user = User::factory()->create([
            'mobile' => '09191234567',
            'password' => bcrypt('password123')
        ]);

        $response = $this->postJson('/api/auth/login', [
            'mobile' => '09191234568',
            'password' => 'password123'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => ['access_token', 'token_type', 'expires_in'],
                'server_time'
            ]);
    }
}
