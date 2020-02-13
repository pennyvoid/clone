<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use App\UserImage;
use Illuminate\Http\UploadedFile;

class AddPostsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }
    /** @test */
    public function a_user_can_post_a_text_post()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($user = factory(User::class)->create(), 'api');
        $response = $this->post(
            '/api/posts',
            [
                'body' => 'body testing',
                'image' => null
            ]

        );
        $this->assertCount(1, Post::all());
        $post = Post::first();
        $response->assertStatus(201)->assertJson(
            [
                'data' => [
                    'type' => 'posts',
                    'post_id' => $post->id,
                    'attributes' => [
                        'posted_by' => [
                            'data' => [
                                'type' => 'users',
                                'user_id' => $user->id,
                                'attributes' => [
                                    'name' => $user->name
                                ]
                            ],
                            'links' => [
                                'self' => url('/users/' . $user->id),
                            ]
                        ],
                        'body' => $post->body,
                        'posted_at' => $post->created_at->diffForHumans()
                    ],
                ],
                'links' => [
                    'self' => url('/posts/' . $post->id)
                ]
            ]
        );
    }

    /** @test */
    public function a_user_can_post_an_image_post()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api');

        $file = UploadedFile::fake()->image('user-post.jpg');

        $response = $this->post('/api/posts', [
            'body' => 'body testing',
            'image' => $file,
            'width' => 800,
            'height' => 800,

        ]);


        Storage::disk('public')->assertExists('post-images/' . $file->hashName());
        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'attributes' => [
                        'body' => 'body testing',
                        'image' => url('storage/post-images/' . $file->hashName()),
                    ],
                ]
            ]);
    }
}
