<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	$faker = Faker\Factory::create();

	$urls = [];

	for($i = 0; $i < 10; $i++)
	{
		$item['id'] = $faker->unique(true)->randomDigitNotNull;
		$item['link'] = $faker->url;
		$item['title'] = $faker->sentence(16);

		$url['url'] = $item;

		$url['favorite'] = $faker->boolean($faker->optional(0.3, true)->randomDigit);

		$urls[] = $url;
	}

	return Response::json($urls,200);
});

Route::group(array('before'=>'auth.token'), function() {  

    Route::resource('urls','UrlController');

});



Route::get('account',[

		'before' => 'auth.token',

		function(){

			$user = Sentry::getUser();

			$token = $user->tokens()->where('client',BrowserDetect::toString())->first();

			return Response::json(array('user' => $user->toArray(), 'token' => $token->toArray()));

		}

	]);

Route::get('restaurants',[

		'before' => 'auth.token',

		function(){

			$restaurants = [];

			for($i = 0; $i < 10; $i++)
			{
				$restaurant['name'] = 'rest_'.$i;
				$restaurant['location'] = 'loc_'.$i;

				$restaurants[] = $restaurant;
			}

			return Response::json($restaurants,200);

		}

	]);
