<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostShowTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function test_first_visit_from_ip_should_record_view(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->create();

        $response = $this->getJson('/api/posts/' . $post->id, ['REMOTE_ADDR' => '1.2.3.4']);

        $response->assertStatus(200);

        $this->assertDatabaseHas('post_views', [
            'post_id' => $post->id,
            'ip' => '1.2.3.4',
        ]);
    }

    public function test_second_visit_from_same_ip_should_not_duplicate(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->create();

        $this->getJson('/api/posts/' . $post->id, ['REMOTE_ADDR' => '5.5.5.5']);

        $this->getJson('/api/posts/' . $post->id, ['REMOTE_ADDR' => '5.5.5.5']);

        $this->assertDatabaseCount('post_views', 1);
    }
}
