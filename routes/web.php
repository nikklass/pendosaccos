<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//send all routes to the home blade

/*Route::any('{all}', function () {
    return view('home');
})
->where(['all' => '.*']);*/

Route::group(['middleware' => 'role:superadministrator|administrator|editor|author|contributor'], function() {

	Route::get('/', 'HomeController@index')->name('home');

	Route::post('logout', 'Auth\LoginController@logout')->name('logout');

	// Password Reset Routes...
	Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset.store');
	Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

	//users routes...
	Route::get('users/create-bulk', 'UserController@showBulkRegistrationForm')->name('users.createbulk');
	Route::post('users/create-bulk', 'UserController@createbulk')->name('users.createbulk.store');
	Route::resource('/users', 'UserController');


	//permission routes...
	Route::resource('/permissions', 'PermissionController', ['except' => 'destroy']);

	//role routes...
	Route::resource('/roles', 'RoleController', ['except' => 'destroy']);

	//group routes...
	Route::resource('/groups', 'GroupController');

	//companies routes...
	Route::resource('/companies', 'CompanyController');

	//smsoutbox routes...
	Route::resource('/smsoutbox', 'SmsOutboxController');

});

Route::group(['middleware' => 'guest'], function() {

	// Authentication Routes...
	Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
	Route::post('login', 'Auth\LoginController@login')->name('login.store');

	// Password Reset Routes...
	Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');

});
