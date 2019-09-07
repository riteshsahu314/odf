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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

// Admin Routes
Route::prefix('admin')->group(function () {

    Route::get('/', 'AdminController@index');

    Route::name('admin.')->group(function () {
        // users
        Route::resource('users', 'AdminUsersController')->except('show');
//        Route::get('users', 'AdminUsersController@index')->name('users');
//        Route::get('users/create', 'AdminUsersController@create')->name('users.create');
//        Route::post('users', 'AdminUsersController@store')->name('users.store');
//        Route::delete('users/{user}', 'AdminUsersController@destroy')->name('users.destroy');
//        Route::get('users/{user}/edit', 'AdminUsersController@edit')->name('users.edit');
//        Route::patch('users/{user}', 'AdminUsersController@update')->name('users.update');

        // channels
        Route::resource('channels', 'AdminChannelsController')->except('show');

        // threads
        Route::resource('threads', 'AdminThreadsController')->except('show', 'create', 'store');
//        Route::get('threads', 'AdminThreadsController@index')->name('threads');
//        Route::delete('threads/{channel}/{thread}', 'AdminThreadsController@destroy')->name('threads.destroy');
//        Route::get('threads/{channel}/{thread}/edit', 'AdminThreadsController@edit')->name('threads.edit');
//        Route::patch('threads/{channel}/{thread}', 'AdminThreadsController@update')->name('threads.update');

        // replies
        Route::resource('replies', 'AdminRepliesController')->except(['create', 'store', 'show']);

        // subscriptions
        Route::get('subscriptions', 'AdminSubscriptionsController@index')->name('subscriptions.index');
        Route::delete('subscriptions/{threadSubscription}', 'AdminSubscriptionsController@destroy')->name('subscriptions.destroy');
    });
});

// User Routes
Route::get('threads/create', 'ThreadsController@create')->middleware('verified');
Route::get('threads/search', 'SearchController@show');
Route::get('threads/{channel}', 'ThreadsController@index');
Route::get('threads/{channel}/{thread}', 'ThreadsController@show');
Route::patch('threads/{channel}/{thread}', 'ThreadsController@update');

Route::delete('threads/{channel}/{thread}', 'ThreadsController@destroy');
Route::post('threads', 'ThreadsController@store');

//Route::patch('threads/{channel}/{thread}', 'ThreadsController@update')->name('threads.update');

Route::post('/replies/{reply}/best', 'BestRepliesController@store')->name('best-replies.store');

Route::post('locked-threads/{thread}', 'LockedThreadsController@store')->name('locked-threads.store')->middleware('admin');
Route::delete('locked-threads/{thread}', 'LockedThreadsController@destroy')->name('locked-threads.destroy')->middleware('admin');

Route::post('threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@store')->middleware('auth');
Route::delete('threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy')->middleware('auth');

Route::get('/threads/{channel}/{thread}/replies', 'RepliesController@index');
Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');
Route::patch('/replies/{reply}', 'RepliesController@update');
Route::delete('/replies/{reply}', 'RepliesController@destroy')->name('replies.destroy');

Route::post('/replies/{reply}/favorites', 'FavoritesController@store');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy');

Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile'); // named route
Route::get('/profiles/{user}/notifications', 'UserNotificationsController@index');
Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy');

Route::get('api/users', 'Api\UsersController@index');
Route::post('api/users/{user}/avatar', 'Api\UserAvatarController@store')->middleware('auth')->name('avatar');
Route::get('threads', 'ThreadsController@index')->name('threads');

