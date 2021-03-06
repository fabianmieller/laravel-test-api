<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Article;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleTest extends TestCase
{
		public function testsArticlesAreCreatedCorrectly(){
			$user = factory(User::class)->create();
			$token = $user->generateToken();
			$headers = ['Authorization' => "Bearer $token"];
			$payload = [
					'title' => 'Lorem',
					'body' => 'Ipsum',
			];

			$this->json('POST', '/api/articles', $payload, $headers)
					->assertStatus(201)
					->assertJson(['title' => 'Lorem', 'body' => 'Ipsum']);
		}

		public function testsArticlesAreUpdatedCorrectly(){
			$user = factory(User::class)->create();
			$token = $user->generateToken();
			$headers = ['Authorization' => "Bearer $token"];
			$article = factory(Article::class)->create([
					'title' => 'First Article',
					'body' => 'First Body',
			]);

			$payload = [
					'title' => 'Lorem',
					'body' => 'Ipsum',
			];

			$response = $this->json('PUT', '/api/articles/' . $article->id, $payload, $headers)
					->assertStatus(200)
					->assertJson([ 
							'title' => 'Lorem', 
							'body' => 'Ipsum' 
					]);
		}

		public function testsArtilcesAreDeletedCorrectly(){
			$user = factory(User::class)->create();
			$token = $user->generateToken();
			$headers = ['Authorization' => "Bearer $token"];
			$article = factory(Article::class)->create([
					'title' => 'First Article',
					'body' => 'First Body',
			]);

			$this->json('DELETE', '/api/articles/' . $article->id, [], $headers)
					->assertStatus(204);
		}
}
