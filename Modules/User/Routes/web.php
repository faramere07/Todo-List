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

Route::prefix('user')->group(function() {
    Route::get('/', 'UserController@index')->name('userHome')->middleware('user');
    Route::post('/updateUserDetailsUsers', 'UserController@updateUserDetailsUsers')->name('updateUserDetailsUsers')->middleware('user');

    Route::get('/changePassword', 'UserController@changePassword')->name('changePasswordUser')->middleware('user');
    Route::post('/', 'UserController@savePassword')->name('savePasswordUser')->middleware('user');
    Route::get('/user_dtb', 'UserController@user_dtb')->name('user_dtb')->middleware('user');
    Route::post('/taskDetails', 'UserController@taskDetails')->name('taskDetails')->middleware('user');
    Route::post('/finishTask', 'UserController@finishTask')->name('finishTask')->middleware('user');
    Route::post('/updateTask', 'UserController@updateTask')->name('updateTask')->middleware('user');

});
