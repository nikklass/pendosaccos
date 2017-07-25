<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function() {
	
	/*Route::get('userList', 'UserController@getUserList');
	Route::get('user/{id}', 'UserController@getUser');*/

	/*admin create user*/
	Route::post('user/create', 'RegistrationController@addUser');

	/* chat urls */
	Route::post('getUserConversation', 'ChatController@getUserConversationById');
	Route::post('chatMessage/create', 'ChatController@addChatToConversation');
	Route::post('chat/notifications', 'ChatController@getChatNotifications');

	/* post urls */
	Route::post('post/create', 'PostController@create');
	Route::get('getPosts', 'PostController@index');
	/*get user posts*/
	Route::get('user/{id}/posts', 'PostController@getUserPosts');
	/*get wall posts*/
	Route::get('wall/{wall_id}/posts', 'PostController@getWallPosts');
	
	//Route::get('getStatus', 'PostController@getStatus');
	//Route::post('post/edit', 'PostController@edit');
	//Route::post('post/delete', 'PostController@delete');

	//get post comments
	Route::get('post/{post_id}/comments', 'CommentController@getPostComments');

	/* comment urls */
	Route::post('comment/create', 'CommentController@create');
	Route::get('getComments', 'CommentController@index');
	Route::put('comment/{id}', 'CommentController@update');
	Route::delete('comment/{id}', 'CommentController@destroy');

	/* likes urls */
	Route::post('like/create', 'LikeController@create');
	Route::get('getLikes', 'LikeController@index');
	//get post likes
	Route::get('post/{post_id}/likes', 'LikeController@getPostLikes');
	/*delete logged in user's like on a post*/
	Route::delete('like/{post_id}', 'LikeController@destroy');

	/*admin url*/
	//Route::get('admin', 'LikeController@index');

});


/*Route::post('forgotPassword', 'UserController@forgotPassword');
Route::post('resetPassword', 'UserController@resetPassword');*/


