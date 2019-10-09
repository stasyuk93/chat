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

Route::middleware(['auth'])->group(function () {
    Route::get('/', 'MessageController@chat');
});

Route::get('color',function (){
   return view('welcome');
});

Route::resource('message','MessageController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
