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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/Activation', 'HomeController@index')->name('Activation');
Route::post('/Activate', 'HomeController@userDetails')->name('Activate');

Route::get('Admin', '\Modules\Admin\Http\Controllers\AdminController@index')->name('Admin');
Route::get('taskMaster', '\Modules\TaskMaster\Http\Controllers\TaskMasterController@index')->name('TaskMaster');
Route::get('User', '\Modules\User\Http\Controllers\UserController@index')->name('User');