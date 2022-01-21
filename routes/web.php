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
Route::get('posts/create', 'PostController@creationForm')->name('create_post_form');
Route::post('/groups/{id}/posts/create', 'PostController@groupCreate')->name('createGroupPost');
Route::post('posts/delete', 'PostController@delete')->name('delete_post');
Route::post('users/{id}/posts/delete', 'PostController@delete')->name('delete_post_admin');
Route::get('posts/edit/{id}', 'PostController@edit')->name('editPost');
Route::post('posts/edit', 'PostController@update')->name('update_post');
Route::post('users/{id]/posts/edit', 'PostController@update')->name('update_post_admin');
Route::get('posts/{post_id}', 'PostController@show')->name('viewPost');
Route::post('posts/{post_id}/like', 'PostController@like')->name('like_post');
Route::post('posts/like', 'PostController@like');

//Search
Route::any('search', 'SearchController@search');
Route::any('search/posts', 'SearchController@postSearch');

//User
//Route::put('users', 'UserController@create');
Route::post('users/delete/{id}', 'UserController@delete')->name('deleteUser');
Route::get('users/delete/{id}', 'UserController@deleteConfirmation');
Route::post('users/edit/{id}', 'UserController@update')->name('editUser');
Route::get('users/edit/{id}', 'UserController@updateForm');
Route::get('users/{id}', 'UserController@show')->name('show_user');  //view profile

//Comment
Route::post('comments', 'CommentController@create')->name('create_comment');

//Friend Requests
Route::get('users/{id}/friends', 'UserController@friends')->name('friends');
Route::get('friends', 'UserController@friends');
Route::post('friends/friend_requests','UserController@createFriendRequest')->name('create_friend_request');
Route::post('friends/friend_requests/delete','UserController@removeFriendRequest')->name('remove_friend_request');
Route::post('friends/delete','UserController@removeFriend')->name('remove_friend');

//Messages
Route::get('messages', 'ChatController@messages')->name('messages_page');
Route::get('messages/{chat_id}', 'ChatController@show')->name('chat');
Route::get('users/{user_id}/messages', 'ChatController@userMessages')->name('user_messages_page'); //For admin view only
Route::get('users/{user_id}/messages/{chat_id}', 'ChatController@userShow')->name('user_chat'); //For admin view only
Route::post('messages/{user_id}', 'ChatController@createChat')->name('createChat');
Route::post('messages/{chat_id}/send', 'ChatController@createMessage')->name('createMessage');

//Notifications
Route::post('notifications/{last_id}','NotificationController@checkNew')->name('check_new_notifications');
Route::post('notifications','NotificationController@get')->name('get_notifications');
Route::get('notifications','NotificationController@get');//TODO remove
Route::put('notifications/{last_id}','NotificationController@consume')->name('consume_notifications');

//Groups
Route::post('groups/create', 'GroupController@create')->name('createGroup');
Route::get('groups', 'GroupController@groups')->name('groups_page');
Route::get('groups/{id}', 'GroupController@show')->name('group_profile');
Route::post('groups/{id}', 'GroupController@delete')->name('deleteGroup');
Route::post('groups/{id}/rename', 'GroupController@rename')->name('renameGroup');
Route::post('groups/{id}/join', 'GroupController@join')->name('joinGroup');
Route::post('groups/{id}/leave', 'GroupController@leave')->name('leaveGroup');
Route::post('groups/{id}/promote', 'GroupController@promote')->name('promoteGroupOwner');
Route::post('groups/{id}/unpromote', 'GroupController@unpromote')->name('unpromoteGroupOwner');

//Administration
Route::get('administration','UserController@listAdministration')->name('show_all_users');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

//Static
Route::get('about',function(){
    return view('pages.about');
});



