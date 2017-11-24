<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
	public function testRequiresEmailAndLogin(){
		$this->json('POST', 'api/login')
				->assertStatus(422)
				->assertJson([
					'email' => ['The email field is required.'],
					'password' => ['The password field is required.'],
				]);
	}

	public function testUserLoginsSuccessfully(){
		$user = factory(User::class)->create([
			'email' => 'testlogin@user.com',
			'password' => bcrypt('fabianASD'),
		]);

		$payload = ['email' => 'testlogin@user.com', 'password' => 'fabianASD'];

		$this->json('POST', 'api/login', $payload)
				->assertStatus(200)
				->assertJsonStructure([
					'data' => [
						'id',
						'name',
						'email',
						'created_at',
						'updated_at',
						'api_token'
					]
				]);
	}

}
