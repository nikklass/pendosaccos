<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function() {

	/*show list of users*/
	Route::get('users/index', 'UserController@index');

	//Route::resource('users', 'UserController');

});


Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function() {

	/*show list of users*/
	//Route::post('users/index', 'UserController@index');


	/*admin url*/
	//Route::get('admin', 'LikeController@index');

});


/*Route::post('forgotPassword', 'UserController@forgotPassword');
Route::post('resetPassword', 'UserController@resetPassword');*/


