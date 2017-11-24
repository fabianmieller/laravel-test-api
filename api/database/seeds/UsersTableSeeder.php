<?php

use Illuminate\Database\Seeder;

use App\User;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Lets clear the useres table first
		User::truncate();

		$faker = \Faker\Factory::create();

		// Let's make sure everyone has the same password and
		// let's hash it before the loop, or else or seeder
		// will be to slow.
		$password = Hash::make('fabian');

		User::create([
			'name' => 'Aministrator',
			'email' => 'admin@test.com',
			'password' => $password,
		]);

		// And now let's generate a few dozen users for our app:
		for ($i=0; $i < 10; $i++) { 
			User::create([
				'name' => $faker->name,
				'email' => $faker->email,
				'password' => $password,
			]);
		}
	}
}
