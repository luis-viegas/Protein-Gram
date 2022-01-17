<?php


use App\Models\Post;
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


// Home
Route::get('/', 'PostController@publicTimeline') -> name('public timeline'); //Main page

//Posts
Route::post('posts/create', 'PostController@create')->name('createPost');
Route::get('posts/create', 'PostController@creationForm');
Route::post('users/{id}', 'PostController@delete')->name('deletePost');
Route::get('posts/edit/{id}', function ($id){return view('pages.editPost', ['post' => Post::find($id)]);} );
Route::post('posts/edit/{id}', 'PostController@update')->name('updatePost');

//Search
Route::any('/search', 'SearchController@search');

//User
//Route::put('users', 'UserController@create');
Route::post('users/delete/{id}', 'UserController@delete')->name('deleteUser');
Route::get('users/delete/{id}', 'UserController@deleteConfirmation');
Route::post('users/edit/{id}', 'UserController@update')->name('editUser');
Route::get('users/edit/{id}', 'UserController@updateForm');
Route::get('users/{id}', 'UserController@show')->name('public_profile');  //view profile

//Comment
Route::post('posts/{id}/comments', 'CommentController@create')->name('create_comment');
Route::post('posts/{post_id}/comments/{comment_id}/responses','CommentController@createResponse')->name('create_response');

//Friend Requests
Route::get('users/{id}/friends', 'UserController@friends')->name('friends');
Route::post('users/{id}/friends/friend_requests','UserController@createFriendRequest')->name('create_friend_request');
Route::post('users/{id}/friends/friend_requests/delete','UserController@removeFriendRequest')->name('remove_friend_request');
Route::post('users/{id}/friends/delete','UserController@removeFriend')->name('remove_friend');

//Administration
Route::get('administration','UserController@listAdministration');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');


//Messages
Route::get('users/{id}/messages', 'ChatController@messages')->name('messages_page');
Route::get('users/{user_id}/messages/{chat_id}', 'ChatController@show')->name('chat');
Route::post('users/{id}/messages', 'ChatController@createChat')->name('createChat');
Route::post('users/{user_id}/messages/{chat_id}', 'ChatController@createMessage')->name('createMessage');


