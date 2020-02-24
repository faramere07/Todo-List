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
    Route::get('/', 'UserController@index')->name('userHome');
    Route::post('/updateUserDetailsUsers', 'UserController@updateUserDetailsUsers')->name('updateUserDetailsUsers');

    Route::get('/changePassword', 'UserController@changePassword')->name('changePasswordUser');
    Route::post('/', 'UserController@savePassword')->name('savePasswordUser');
    Route::get('/user_dtb', 'UserController@user_dtb')->name('user_dtb');
    Route::post('/taskDetails', 'UserController@taskDetails')->name('taskDetails');
    Route::post('/finishTask', 'UserController@finishTask')->name('finishTask');
    Route::post('/updateTask', 'UserController@updateTask')->name('updateTask');

});
