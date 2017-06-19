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

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('category/search', ['as' => 'categoryAjax', 'uses' => 'CategoryController@search']);

Route::get('tag/search', ['as' => 'tagAjax', 'uses' => 'TagController@search']);

Route::get('auth/facebook', 'Auth\AuthController@redirectToFacebook');

Route::get('auth/facebook/callback', 'Auth\AuthController@handleFacebookCallback');

Route::get('posts', 'PostController@recentlyPosts')->name('posts.list');
Route::get('posts/{id}', 'PostController@view')->name('posts.view');

Route::get('tags', 'TagController@index')->name('tags.list');

Route::get('categories', 'TagController@index')->name('categories.list');

// For memeber
Route::group(['middleware' => ['auth']], function(){
	Route::resource('my-posts', 'PostController');
	Route::get('profiles', 'ProfileController@index')->name('profiles.index');
    Route::match(['put', 'patch'], 'profiles/update', 'ProfileController@update')->name('profiles.update');
    Route::get('profiles/edit', 'ProfileController@edit')->name('profiles.edit');
});
//For admin
Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'namespace' => 'Admin'], function() {
	Route::resource('posts', 'PostController', ['middleware' => 'permission:posts-manager']);

	Route::resource('tags', 'TagController', ['middleware' => 'permission:tags-manager']);

	Route::resource('categories', 'CategoryController', ['middleware' => 'permission:categories-manager']);

	Route::resource('users','UserController', ['middleware' => 'permission:users-manager']);

    Route::resource('roles', 'RoleController', ['middleware' => 'permission:roles-manager']);

    Route::resource('permissions', 'PermissionController', ['middleware' => 'permission:permissions-manager']);
});

//For test
Route::get('mail', 'HomeController@mail');

Route::get('/send_email', array('uses' => 'EmailController@sendEmailReminder'));