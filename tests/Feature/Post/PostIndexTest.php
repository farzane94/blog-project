<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostIndexTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_posts(): void
    {
        $me = User::factory()->create();

        Post::factory()->count(2)->for($me)->create();

        $this->actingAs($me, 'api');

        $response = $this->getJson('/api/posts');

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data.posts');
    }
}
