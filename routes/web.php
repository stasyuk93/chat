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

Route::get('/login','LoginController@loginPage')->name('login');
Route::post('/login','LoginController@login');
Route::post('/logout','LoginController@logout')->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/', 'MessageController@chat');
});


Route::prefix('react')->group(function (){
    Route::get('{path?}', function(){
        return view('react.app');
    });
});
