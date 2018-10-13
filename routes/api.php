<?php

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {

    $api->group(['middleware' => 'api.auth'], function(Router $api) {
    // $api->group(['prefix' => ''], function(Router $api) {
        $api->get('protected', function() {
            return response()->json([
                'message' => 'Access to protected resources granted! You are seeing this text as you provided the token correctly.'
            ]);
        });

        $api->group(['prefix' => 'profiles'], function(Router $api) {
            $api->get('', 'App\Api\V1\Controllers\ProfilesController@index');
            $api->get('getprofile', 'App\Api\V1\Controllers\ProfilesController@getProfile');
            $api->post('', 'App\Api\V1\Controllers\ProfilesController@createOrUpdate');
            $api->put('', 'App\Api\V1\Controllers\ProfilesController@createOrUpdate');
            $api->get('search/{search}', 'App\Api\V1\Controllers\ProfilesController@search');

        });

        $api->group(['prefix' => 'expertise'], function(Router $api) {
            $api->get('', 'App\Api\V1\Controllers\ExpertiseController@index');
      	    $api->get('{id}', 'App\Api\V1\Controllers\ExpertiseController@show');
            $api->post('', 'App\Api\V1\Controllers\ExpertiseController@store');
            $api->post('store', 'App\\Api\\V1\\Controllers\\ExpertiseController@store');
      	    $api->put('{id}', 'App\Api\V1\Controllers\ExpertiseController@update');
            $api->delete('{id}', 'App\Api\V1\Controllers\ExpertiseController@destroy');
        });
    });

    $api->get('hello', function() {
        return response()->json([
            'message' => config('app.rocketchat_url')
        ]);
    });
});
