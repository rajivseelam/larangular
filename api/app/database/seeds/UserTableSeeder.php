<?php

class UserTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		DB::table('users')->truncate();

		Sentry::createUser(array(
	        'email'     => 'admin@laragunlar.com',
	        'password'  => 'secret',
	        'activated' => true,
	        'permissions' => array(
	            'superuser' => 1
	        ),
	    ));

	    Sentry::createUser(array(
	        'email'     => 'guest@laragunlar.com',
	        'password'  => 'secret',
	        'activated' => true
	    ));
	}

}
