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
    Route::get('/', 'AdminController@index')->name('adminHome')->middleware('admin');
    Route::get('/Users', 'AdminController@viewUsers')->name('viewUsers')->middleware('admin');
    Route::get('/tasks', 'AdminController@viewTask')->name('viewTask')->middleware('admin');
    Route::post('/AddUser', 'AdminController@addUser')->name('addUser')->middleware('admin');
    Route::get('/user_profile/{id}', 'AdminController@viewUser')->name('viewUser')->middleware('admin');
    Route::post('/taskDetails', 'AdminController@taskDetails')->name('taskDetailsAdmin');



    Route::get('/people_dtb', 'AdminController@usersShow')->name('usersShow')->middleware('admin');
    Route::post('/storeAdd', 'AdminController@storeAdd')->name('storeAdd')->middleware('admin');
    Route::post('/editUser', 'AdminController@editUser')->name('editUser')->middleware('admin');
    Route::post('/saveEditUser', 'AdminController@saveEditUser')->name('saveEditUser')->middleware('admin');
    Route::post('/destroyUser', 'AdminController@destroyUser')->name('destroyUser')->middleware('admin');

    Route::get('/adduser', 'AdminController@adduser')->name('adduser')->middleware('admin');
    Route::get('/changePassword', 'AdminController@changePassword')->name('changePassword')->middleware('admin');
    Route::post('/', 'AdminController@savePassword')->name('savePassword')->middleware('admin');

    




});
