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

use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'PostController@index')->name('home');


    Route::post('/createpost', 'PostController@postcreatePost')->name('post.create');
    Route::get('/deletepost/{post_id}', 'PostController@deletepost')->name('post.delete');
    Route::post('/edit', 'PostController@editpost')->name('edit');
    Route::get('/account', 'PostController@getAccount')->name('account');
    Route::Post('/updateaccount', 'PostController@postsaveaccount')->name('account.save');
    Route::get('/userimage/{filename}', 'PostController@getimage')->name('account.image');
    Route::Post('/like', 'PostController@postLike')->name('like');







