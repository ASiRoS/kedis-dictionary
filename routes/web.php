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

Route::get('/', 'WordController@index')->name('home');

Route::resource('words', 'WordController');

Route::get('/search', 'WordController@search')->name('words.search');

Route::get('/users/{user}/words', 'UserController@words')->name('users.specific.words');

Route::get('/users/words', 'UserController@mineWords')->name('users.words');

Route::post('/comments/{word}', 'CommentController@store')->name('comments.store')->middleware('auth');

Auth::routes();


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
