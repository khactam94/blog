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

Route::get('posts', 'PostController@index')->name('posts.index');
Route::get('posts/{id}', 'PostController@show')->name('posts.show');
Route::get('tags', 'TagController@index')->name('tags.index');
Route::get('tags/{id}', 'TagController@show')->name('tags.show');
Route::get('categories', 'CategoryController@index')->name('categories.index');
Route::get('categories/{id}', 'CategoryController@show')->name('categories.show');

// For memeber
Route::group(['middleware' => ['auth']], function(){
	Route::resource('my_posts', 'MyPostController');
	Route::get('profiles', 'ProfileController@index')->name('profiles.index');
    Route::match(['put', 'patch'], 'profiles/update', 'ProfileController@update')->name('profiles.update');
    Route::get('profiles/edit', 'ProfileController@edit')->name('profiles.edit');
});
//For admin
Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function() {
	Route::resource('posts', 'PostController', ['middleware' => 'permission:posts-manager']);
    Route::get('post/datatable', 'PostController@datatable')->name('posts.list');
    Route::delete('deleteAllPosts', 'PostController@deleteAll')->name('posts.deleteAll');
	Route::resource('tags', 'TagController', ['middleware' => 'permission:tags-manager']);

	Route::resource('categories', 'CategoryController', ['middleware' => 'permission:categories-manager']);

	Route::resource('users','UserController', ['middleware' => 'permission:users-manager']);

    Route::resource('roles', 'RoleController', ['middleware' => 'permission:roles-manager']);

	Route::resource('permissions', 'PermissionController', ['middleware' => 'permission:permissions-manager']);
	
	Route::get('/download', 'BackupController@download');
});

Route::group(['middleware' => ['auth'], 'prefix' => 'api', 'namespace' => 'API', 'as' => 'api.'], function() {
    Route::resource('categories', 'APICategoryController', ['only' => 'destroy', 'middleware' => 'permission:categories-manager']);
});
//For test
Route::get('mail', 'HomeController@mail');

Route::get('/send_email', array('uses' => 'EmailController@sendEmailReminder'));

Route::resource('items', 'ItemController');
Route::get('item/datatable', 'ItemController@datatable')->name('items.list');

//--------------------------------------- donate -----------------------------------------------------
// Get Route For Show Payment Form
Route::get('donate', 'RazorpayController@donate')->name('donate');
// Post Route For Makw Payment Request
Route::post('payment', 'RazorpayController@payment')->name('payment');