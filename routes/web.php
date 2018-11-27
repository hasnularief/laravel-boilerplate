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
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');
Route::get('/profile', 'HomeController@profile')->name('home.profile');
Route::post('/profile', 'HomeController@writeProfile')->name('home.profile');

Route::get('/users','Administrator\UsersController')->name('users');
Route::get('/users/read','Administrator\UsersController@read')->name('users.read');
Route::post('/users/write','Administrator\UsersController@write')->name('users.write');

Route::group(['name' => 'Roles::'], function(){
	Route::get('/roles', 'Administrator\RolesController')->name('roles');
	Route::get('/roles/read', 'Administrator\RolesController@read')->name('roles.read');
	Route::post('/roles/write', 'Administrator\RolesController@write')->name('roles.write');
});

Route::group(['name' => 'Permissions::'], function(){
 	Route::get('/permissions', 'Administrator\PermissionsController')->name('permissions');
 	Route::get('/permissions/read', 'Administrator\PermissionsController@read')->name('permissions.read');
 	Route::post('/permissions/write', 'Administrator\PermissionsController@write')->name('permissions.write');
});

