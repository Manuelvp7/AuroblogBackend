<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PostTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

     public function testPostsAreCreatedCorrectly()
     {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $payload = [
            'title' => 'Lorem',
            'content' => 'Ipsum',
            'slug' => Str::slug('Lorem')
        ];

        $this->json('POST', '/api/posts', $payload, $headers)
            ->assertStatus(201)
            ->assertJson(["title" => "Lorem", "content" => "Ipsum", "slug" => Str::slug('Lorem')]);





     }


     public function testPostsAreCreatedCorrectlyOnDuplicatedSlug()
     {


        $user = factory(User::class)->create();
        $token = $user->generateToken();

        for ($i=0; $i < 10; $i++) {
            $post = factory(Post::class)->create([
                'title' => 'First Article',
                'content' => 'First Body',
            ]);
        }

        $headers = ['Authorization' => "Bearer $token"];

        $payload = [
            'title' => 'First Article',
            'content' => 'First Body',
        ];

        $uniquePayload = [
            'title' => 'Unique Article',
            'content' => 'Unique content',
        ];



        $this->json('POST', '/api/posts', $payload, $headers)
            ->assertStatus(201)
            ->assertJson(["title" => "First Article", "content" => "First Body", "slug" => 'first-article-10']);


        $this->json('POST', '/api/posts', $uniquePayload, $headers)
            ->assertStatus(201)
            ->assertJson(["title" => "Unique Article", "content" => "Unique content", "slug" => 'unique-article']);


     }



     public function testPostsAreUpdatedCorrectly()
     {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $post = factory(Post::class)->create([
            'title' => 'First Article',
            'content' => 'First Body',
            'slug' => Str::slug('First Article')
        ]);

        $payload = [
            'title' => 'Lorem',
            'content' => 'Ipsum',
            'slug' => Str::slug('Lorem')
        ];

        $response = $this->json('PUT', '/api/posts/'.$post->id, $payload, $headers)
            ->assertStatus(200)
            ->assertJson([
                "id" => 1,
                "title" => "Lorem",
                "slug" => Str::slug('Lorem'),
                "content" => "Ipsum"

            ]);
     }

     public function testPostsAreDeletedCorrectly()
     {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $post = factory(Post::class)->create([
            'title' => 'First Article',
            'content' => 'First Body',
            'slug' => Str::slug('First Article')
        ]);

        $this->json('DELETE', '/api/posts/' . $post->id, [], $headers)
            ->assertStatus(204);
     }

     public function testPostsAreListedCorrectly()
     {

        factory(Post::class)->create([
            'title' => 'First Article',
            'content' => 'First Body',
            'slug' => Str::slug('First Article')
        ]);

        factory(Post::class)->create([
            'title' => 'Second Article',
            'content' => 'Second Body',
            'slug' => Str::slug('Second Article')
        ]);

        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer ".$token];

        $response = $this->json('GET', '/api/posts', [], $headers)
        ->assertStatus(200)
        ->assertJson([
            [ 'title' => 'First Article', 'content' => 'First Body' ],
            [ 'title' => 'Second Article', 'content' => 'Second Body' ]
        ])
        ->assertJsonStructure([
            '*' => ['id', 'title', 'slug', 'content',  'created_at', 'updated_at', 'deleted_at' ]
        ]);

     }
}
