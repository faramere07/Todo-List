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

Route::prefix('admin')->group(function() {
    Route::get('/', 'AdminController@index')->name('adminHome');
    Route::get('/Users', 'AdminController@viewUsers')->name('viewUsers');
    Route::get('/tasks', 'AdminController@viewTask')->name('viewTask');




    Route::get('/people_dtb', 'AdminController@usersShow')->name('usersShow');
    Route::post('/storeAdd', 'AdminController@storeAdd')->name('storeAdd');
    Route::post('/editUser', 'AdminController@editUser')->name('editUser');
    Route::post('/saveEditUser', 'AdminController@saveEditUser')->name('saveEditUser');
    Route::post('/destroyUser', 'AdminController@destroyUser')->name('destroyUser');

    Route::get('/adduser', 'AdminController@adduser')->name('adduser');
    Route::get('/changePassword', 'AdminController@changePassword')->name('changePassword');
    Route::post('/', 'AdminController@savePassword')->name('savePassword');

    




});
