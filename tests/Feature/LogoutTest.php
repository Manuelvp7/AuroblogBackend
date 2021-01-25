<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

     public function testUserIsLoggedOutProperly()
     {
        $user = factory(User::class)->create(['email' => 'admin2@admin2.com']);
        $token = $user->generateToken();
        $headers = ['Authorization' => 'Bearer '.$token];

        $this->json('get', '/api/posts', [], $headers)->assertStatus(200);
        $this->json('post', '/api/logout', [], $headers)->assertStatus(200);

        $user = User::find($user->id);

        $this->assertEquals(null, $user->api_token);
     }

     public function testUserWithNullToken(){
        $user = factory(User::class)->create(['email' => 'admin2@admin.com']);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $user->api_token = null;
        $user->save();
        $this->json('get', 'api/posts', [], $headers)->assertStatus(401);
     }
}
