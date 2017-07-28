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


View::share('passport_client_id', \Config::get('constants.passport.client_id'));
View::share('passport_client_secret', \Config::get('constants.passport.client_secret'));
View::share('passport_login_url', \Config::get('constants.passport.login_url'));
View::share('passport_user_url', \Config::get('constants.passport.user_url'));


View::share('get_users_url', \Config::get('constants.routes.get_users_url'));
View::share('send_message_url', \Config::get('constants.routes.send_message_url'));
View::share('create_user_url', \Config::get('constants.routes.create_user_url'));
View::share('create_message_url', \Config::get('constants.routes.create_message_url'));




Route::group(['middleware' => 'role:superadministrator|administrator|editor|author|contributor'], function() {

	Route::get('/', 'HomeController@index')->name('home');

	Route::post('logout', 'Auth\LoginController@logout')->name('logout'); 

	// Password Reset Routes...
	Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset.store');
	Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

	//handle bulk import user...
	Route::get('users/create-bulk', 'UserImportController@create')->name('bulk-users.create');
	Route::post('users/create-bulk', 'UserImportController@store')->name('bulk-users.store');
	
	//user routes...
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
	Route::resource('/smsoutbox', 'SmsOutboxController', ['except' => 'destroy']);

	//schedule smsoutbox routes...
	Route::resource('/scheduled-smsoutbox', 'ScheduleSmsOutboxController');

});

Route::group(['middleware' => 'guest'], function() {

	// Authentication Routes...
	Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
	Route::post('login', 'Auth\LoginController@login')->name('login.store');

	// Password Reset Routes...
	Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');

});
