<?php

namespace Tests\Feature\User;

use App\Models\Post;
use App\Models\PostView;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRankingTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_are_ranked_by_total_post_views(): void
    {
        $firstUser = User::factory()->create(['name' => 'A']);
        $secondUser = User::factory()->create(['name' => 'B']);

        $firstPost = Post::factory()->for($firstUser)->create();
        $secondPost = Post::factory()->for($secondUser)->create();

        foreach (range(1, 5) as $i) {
            PostView::factory()->create([
                'post_id' => $firstPost->id,
                'ip' => "192.168.0.$i",
            ]);
        }

        foreach (range(1, 5) as $i) {
            PostView::factory()->create([
                'post_id' => $secondPost->id,
                'ip' => "192.168.0.$i",
            ]);
        }


        $response = $this->getJson('/api/rankings/users');

        $response->assertStatus(200)
            ->assertJsonPath('data.users.0.name', 'A')
            ->assertJsonPath('data.users.1.name', 'B');
    }
}
