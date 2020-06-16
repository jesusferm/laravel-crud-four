<?php

use Illuminate\Support\Facades\Route;

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
	return view('main');
});

Auth::routes();


Route::group(['middleware' => 'auth'], function () {
	Route::resource('/posts', 'PostsController');
		/**
	 * se redirecciona a la lista de registros que tenga el usuario*/
	Route::get('/home', 'PostsController@index')->name('home');
});

Route::group(['middleware' => 'auth'], function () {
	Route::get('/post/{slug?}', ['as' => 'posts.post', 'uses' => 'PostsController@view']);
});

Route::get('/add', 'PostsController@create');
Route::get('/postinsert', 'PostsController@ajaxAdd');
Route::post('/postinsert', 'PostsController@ajaxAdd');
Route::get('/postupdate', 'PostsController@ajaxUpdate');
Route::post('/postupdate', 'PostsController@ajaxUpdate');
Route::post('/postdelete', 'PostsController@ajaxDelete');

Route::post('/accountupdate', 'UsersController@upProfile');
Route::post('/upimage', 'UsersController@upImage');
Route::post('/loadimage', 'UsersController@loadImage');
Route::post('/uppassword', 'UsersController@upPassword');



Route::post('/page', 'PostsController@load');

Route::get('/{slug?}', ['as' => 'home.view', 'uses' => 'HomeController@view']);