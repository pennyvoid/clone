<?php

namespace Tests\Feature;

use App\Like;
use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostLikesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_like_post()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($user = factory(User::class)->create(), 'api');
        $post = factory(Post::class)->create(['id' => 11]);
        $response = $this->post('/api/posts/' . $post->id . '/like')->assertStatus(200);
        $this->assertCount(1, $post->likes);
        $this->assertCount(1, $user->likedPosts);
        $response->assertJson([
            'data' => [
                [
                    'data' => [
                        'type' => 'likes',
                        'like_id' => 1,
                        'attributes' => []
                    ], 'links' => [
                        'self' => url('/posts/' . $post->id)
                    ]
                ]
            ], 'links' => [
                'self' => url('/posts')
            ]
        ]);
    }

    /** @test */
    public function posts_are_returned_with_likes()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api');

        $post = factory(Post::class)->create(['id' => 11, 'user_id' => $user->id]);

        $this->post('/api/posts/' . $post->id . '/like')->assertStatus(200);

        $like = Like::first();

        $this->assertCount(1, Like::all());

        $response = $this->get('/api/posts')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'data' => [
                            'type' => 'posts',
                            'attributes' => [
                                'likes' => [
                                    'data' => [
                                        [
                                            'data' => [
                                                'type' => 'likes',
                                                'like_id' => $like->id,
                                                'attributes' => []
                                            ]
                                        ]
                                    ],
                                    'like_count' => 1,
                                    'user_likes_post' => true
                                ]
                            ]
                        ]
                    ]
                ]
            ]);
    }
}
