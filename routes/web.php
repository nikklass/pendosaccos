<?php

View::share('passport_client_id', config('constants.passport.client_id'));
View::share('passport_client_secret', config('constants.passport.client_secret'));
View::share('passport_login_url', config('constants.passport.login_url'));
View::share('passport_user_url', config('constants.passport.user_url'));

View::share('get_users_url', config('constants.routes.get_users_url'));
View::share('send_message_url', config('constants.routes.send_message_url'));
View::share('create_user_url', config('constants.routes.create_user_url'));
View::share('create_message_url', config('constants.routes.create_message_url'));

//all logged in users routes
Route::group(['middleware' => 'auth'], function() {
	
	Route::get('/', 'HomeController@index')->name('home');

	//member account routes...
	Route::resource('/member-accounts', 'MemberAccountController');

	//withdrawals routes...
	Route::resource('/withdrawals', 'WithdrawalController');
	
	//deposits routes...
	Route::resource('/deposits', 'DepositController');

	//repayments routes...
	Route::resource('/repayments', 'RepaymentController');

	//loans routes...
	Route::resource('/loans', 'LoanController');

	//logout route...
	Route::post('logout', 'Auth\LoginController@logout')->name('logout'); 

});

//admins only routes
Route::group(['middleware' => 'role:superadministrator|administrator|groupadministrator|manager'], function() {
	
	//export to excel data...
	Route::get('excel/export-smsoutbox/{type}', 'ExcelController@exportOutboxSmsToExcel')->name('excel.export-smsoutbox');
	Route::get('excel/export-groups/{type}', 'ExcelController@exportGroupsToExcel')->name('excel.export-groups');

	//handle bulk import user...
	Route::get('users/create-bulk', 'UserImportController@create')->name('bulk-users.create');
	Route::post('users/create-bulk', 'UserImportController@store')->name('bulk-users.store');
	Route::get('users/create-bulk/get-data/{uuid}', 'UserImportController@getImportData')->name('bulk-users.getimportdata');
	Route::get('users/create-bulk/get-incomplete/{uuid}', 'UserImportController@getIncompleteData')->name('bulk-users.getincompletedata');	

	//send email routes...
	Route::get('/email/newUser', 'EmailController@newUserEmail')->name('email.newuser');

	//user routes...
	Route::resource('/users', 'UserController');

	//user profile routes...
	Route::get('/profile/{id}', 'ProfileController@indexId')->name('user.profile.id');
	Route::get('/profile', 'ProfileController@index')->name('user.profile'); 

	//group routes...
	Route::resource('/groups', 'GroupController');

	//smsoutbox routes...
	Route::resource('/smsoutbox', 'SmsOutboxController', ['except' => ['edit', 'destroy']]);

	//schedule smsoutbox routes...
	Route::resource('/scheduled-smsoutbox', 'ScheduleSmsOutboxController');

	//accounts routes...
	Route::resource('/accounts', 'AccountController');

	//mpesac2b routes...
	Route::resource('/mpesa/mpesac2b', 'Mpesac2bController');

});

//superadmin only routes
Route::group(['middleware' => 'role:superadministrator'], function() {

	//permission routes...
	Route::resource('/permissions', 'PermissionController', ['except' => 'destroy']);

	//role routes...
	Route::resource('/roles', 'RoleController', ['except' => 'destroy']);

});

//guest only routes
Route::group(['middleware' => 'guest'], function() {

	// Authentication Routes...
	Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
	Route::post('login', 'Auth\LoginController@login')->name('login.store');

	// Password Reset Routes...
	Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset.store');
	Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

	Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');

});
