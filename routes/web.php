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
Route::get('posts/{post_id}', 'PostController@show')->name('viewPost');

//Search
Route::any('search', 'SearchController@search');

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

//Messages
Route::get('messages', 'ChatController@messages')->name('messages_page');
Route::get('messages/{chat_id}', 'ChatController@show')->name('chat');
Route::get('users/{user_id}/messages', 'ChatController@userMessages')->name('user_messages_page'); //For admin view only
Route::get('users/{user_id}/messages/{chat_id}', 'ChatController@userShow')->name('user_chat'); //For admin view only
Route::post('messages/{user_id}', 'ChatController@createChat')->name('createChat');
Route::post('messages/{chat_id}/send', 'ChatController@createMessage')->name('createMessage');

//Administration
Route::get('administration','UserController@listAdministration')->name('show_all_users');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');




