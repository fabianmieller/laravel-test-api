<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutTest extends TestCase
{
	public function testUserIsLoggedOutProperly(){
		$user = factory(User::class)->create(['email' => 'user@test.com']);
		$token = $user->generateToken();
		$headers = ['Authorization' => "Bearer $token"];

		$this->json('GET', '/api/articles', [], $headers)->assertStatus(200);
		$this->json('POST', '/api/logout', [], $headers)->assertStatus(200);

		$user = User::find($user->id);

		$this->assertEquals(null, $user->api_token);
	}

	public function testUserWithNullToken(){
		// Simulation login
		$user = factory(User::class)->create(['email' => 'user@test.com']);
		$token = $user->generateToken();
		$headers = ['Authorization' => "Bearer $token"];

		// Simulating logout
		$user->api_token = null;
		$user->save();

		$this->json('GET', '/api/articles', [], $headers)->assertStatus(401);
	}

}
