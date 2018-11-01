<?php

use Illuminate\Support\Facades\Route;
// use Illuminate\Routing\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PublicController;
//use Symfony\Component\Routing\Route;

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


Route::get('/', 'PublicController@index')->name('index');
Route::get('/test', function () {
    return view('test');
});


Auth::routes();

Route::prefix('user')->group(function(){
    Route::get('{channel}/posts/new', 'UserController@newPost')->name('newPost');
    Route::post('{channel}/posts/new', 'UserController@createPost')->name('createPost');
    Route::post('new-reply', 'UserController@newReply')->name('newReply');

    Route::get('dashboard', 'UserController@dashboard')->name('userDashboard');

    Route::get('posts', 'UserController@posts')->name('userPosts');
    Route::get('post/{id}/edit', 'UserController@postEdit')->name('postEdit');
    Route::post('post/{id}/edit', 'UserController@postEditPost')->name('postEditPost');

    Route::get('replies', 'UserController@replies')->name('userReplies');
    Route::get('reply/{id}/edit', 'UserController@replyEdit')->name('editReply');
    Route::post('reply/{id}/edit', 'UserController@replyEditPost')->name('replyEditPost');
    Route::post('reply/{id}/delete', 'UserController@deleteReply')->name('deleteReply');
    

    Route::get('profile', 'UserController@profile')->name('userProfile');
    Route::post('profile', 'UserController@profilePost')->name('userProfilePost');
});


Route::prefix('admin')->group(function(){
    Route::get('dashboard', 'AdminController@dashboard')->name('adminDashboard');
    Route::get('channels', 'AdminController@channels')->name('adminChannels');
    Route::get('channels/new', 'AdminController@newChannel')->name('newChannel');
    Route::post('channels/new', 'AdminController@newChannelPost')->name('newChannelPost');
    Route::get('channels/{id}/edit', 'AdminController@channelEdit')->name('adminChannelEdit');
    Route::post('channels/{id}/edit', 'AdminController@channelEditPost')->name('adminChannelEditPost');
    Route::post('channels/{id}/delete', 'AdminController@deleteChannel')->name('adminDeleteChannel');

    Route::get('posts', 'AdminController@posts')->name('adminPosts');
    Route::get('post/{id}/edit', 'AdminController@postEdit')->name('adminPostEdit');
    Route::post('post/{id}/edit', 'AdminController@postEditPost')->name('adminPostEditPost');
    Route::post('post/{id}/delete', 'AdminController@deletePost')->name('adminDeletePost');
    Route::get('post/{id}/replies', 'AdminController@postReplies')->name('adminPostReplies');
    Route::get('post/{postId}/replies/{replyId}/edit', 'AdminController@replyEdit')->name('adminEditReply');
    Route::post('post/{postId}/replies/{replyId}/edit', 'AdminController@replyEditPost')->name('adminEditReplyPost');
    Route::post('post/{postId}/replies/{replyId}/delete', 'AdminController@deleteReply')->name('adminDeleteReply');

    Route::get('comments', 'AdminController@comments')->name('adminComments');
    Route::post('comment/{id}/delete', 'AdminController@deleteComment')->name('adminDeleteComment');

    Route::get('users', 'AdminController@users')->name('adminUsers');
    Route::get('user/{id}/edit', 'AdminController@editUser')->name('adminEditUser');
    Route::post('user/{id}/edit', 'AdminController@editUserPost')->name('adminEditUserPost');
    Route::post('user/{id}/delete', 'AdminController@deleteUser')->name('adminDeleteUser');
});

Route::get('/{channel}', 'PublicController@channelPosts')->name('channelPosts');
Route::get('/{channel}/{post}', 'PublicController@singlePost')->name('singlePost');