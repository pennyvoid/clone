<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use App\Comment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostCommentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_comment_a_post()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($user = factory(User::class)->create(), 'api');

        $post = factory(Post::class)->create(['id' => 11]);

        $response = $this->post('/api/posts/' . $post->id . '/comment', [
            'body' => 'comment here',

        ])->assertStatus(200);

        $comment = Comment::first();

        $this->assertCount(1, Comment::all());

        $this->assertEquals($user->id, $comment->user_id);

        $this->assertEquals($post->id, $comment->post_id);

        $this->assertEquals('comment here', $comment->body);

        $response->assertJson([
            'data' => [
                [
                    'data' => [
                        'type' => 'comments',
                        'comment_id' => $comment->id,
                        'attributes' => [
                            'body' => $comment->body,
                            'commented_at' => $comment->created_at->diffForHumans(),
                            'commented_by' => [
                                'data' => [
                                    'type' => 'users',
                                    'user_id' => $user->id,
                                    'attributes' => [
                                        'name' => $user->name
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'links' => [
                        'self' => url('/posts/' . $post->id)
                    ]
                ]
            ],
            'links' => [
                'self' => url('/posts')
            ]
        ]);
    }

    /** @test */
    public function a_body_is_required_to_leave_comment_on_a_post()
    {

        $this->actingAs($user = factory(User::class)->create(), 'api');

        $post = factory(Post::class)->create(['user_id' => $user->id]);

        $response = $this->post('api/posts/' . $post->id . '/comment', [
            'body' => ''
        ])->assertStatus(422);


        $responseString = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('body', $responseString['errors']['meta']);
    }

    /** @test */

    public function posts_are_returned_with_comments()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');

        $post = factory(Post::class)->create();

        $this->post('api/posts/' . $post->id . '/comment', [
            'body' => 'comment here'
        ])->assertStatus(200);

        $comment = Comment::first();

        $response = $this->get('/api/posts')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'data' => [
                            'type' => 'posts',
                            'attributes' => [
                                'comments' => [
                                    'data' => [
                                        [
                                            'data' => [
                                                'type' => 'comments',
                                                'comment_id' => $comment->id,
                                                'attributes' => [
                                                    'body' => $comment->body,
                                                    'commented_by' => [
                                                        'data' => [
                                                            'type' => 'users',
                                                            'user_id' => $user->id,
                                                            'attributes' => [
                                                                'name' => $user->name
                                                            ]
                                                        ]
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ],
                                    'comment_count' => 1,
                                    'links' => [
                                        'self' => url('/posts')
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                'links' => [
                    'self' => url('/posts')
                ]
            ]);
    }
}
