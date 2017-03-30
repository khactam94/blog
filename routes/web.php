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

Auth::routes();

Route::get('/home', ['as' => 'home', 'uses' => 'HomeController@index']);

Route::get('category/search', ['as' => 'categoryAjax', 'uses' => 'CategoryController@search']);

Route::get('tag/search', ['as' => 'tagAjax', 'uses' => 'TagController@search']);

Route::get('auth/facebook', 'Auth\AuthController@redirectToFacebook');
Route::get('auth/facebook/callback', 'Auth\AuthController@handleFacebookCallback');

Route::resource('posts', 'PostController');

Route::resource('tags', 'TagController');

Route::resource('categories', 'CategoryController');
Auth::routes();

