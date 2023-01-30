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


Auth::routes();

Route::get("/", "PostController@index")->name('top');

Route::resource('posts', 'PostController');

Route::resource('follows', 'FollowController')->only([
  'index', 'store', 'destroy'
]);
 
Route::get('/follower', 'FollowController@followerIndex');

Route::resource('users', 'UserController')->only([
   'show',
]);

Route::get("/serch", "PostController@serch")->name('posts.serch');
