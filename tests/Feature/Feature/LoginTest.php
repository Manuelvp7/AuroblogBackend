<?php

namespace Tests\Feature\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */


    public function testRequiresEmailAndLogin()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(422)
            ->assertJson([
                "message" => 'The given data was invalid.',
                "errors" => [
                    "email" => ["The email field is required."],
                    "password" => [ "The password field is required."]
                ]

            ]);
    }

    public function testUserLoginSuccesfully()
    {
        $user = factory(User::class)->create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),
        ]);

        $payload = ['email'=> 'admin@admin.com', 'password' => '123456'];

        $this->json('POST', 'api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                    'api_token',
                ]
            ]);
    }
}
