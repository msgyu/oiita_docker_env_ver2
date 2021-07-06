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

Route::get('/', 'PostController@index')->name('posts.index');


Route::post('/like_product', 'LikeController@like_product')->middleware('auth');

Route::prefix('posts')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/create', 'PostController@edit')->name('post.create');
        Route::get('/my_posts', 'PostController@myPosts')->name('my_posts');
        Route::get('/likes', 'LikeController@index')->name('likes.index');
    });

    Route::middleware('can:update,post')->group(function () {
        Route::get('/{id}/edit', 'PostController@edit')->name('post.edit');
        Route::put('/{id}/update', 'PostController@update')->name('post.update');
        Route::delete('/{id}/delete', 'PostController@destroy')->name('post.destroy');
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
