<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
	public function testsRegistersSuccessfully(){
		$payload = [
			'name' => 'Max',
			'email' => 'max@hello.com',
			'password' => 'maxii123',
			'password_confirmation' => 'maxii123',
		];

		$this->json('POST', '/api/register', $payload)
				->assertStatus(201)
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

	public function testsRequiresPasswordEmailAndName(){
		$this->json('POST', '/api/register')
				->assertStatus(422)
				->assertJson([
					'errors' => [
						'name' => ['The name field is required.'],
						'email' => ['The email field is required.'],
						'password' => ['The password field is required.'],
					]
				]);
	}

	public function testsRequirePasswordConfirmation(){
		$payload = [
			'name' => 'Max',
			'email' => 'max@hello.com',
			'password' => 'maxii123',
		];

		$this->json('POST', '/api/register', $payload)
				->assertStatus(422)
				->assertJson([
					'errors' => [
						'password' => ['The password confirmation does not match.'],
					]
				]);
	}

}
