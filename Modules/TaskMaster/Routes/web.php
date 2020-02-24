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

Route::prefix('taskmaster')->group(function() {
    Route::get('/', 'TaskMasterController@index')->name('taskmasterHome');
    Route::get('/project_dtb', 'TaskMasterController@project_dtb')->name('project_dtb');
    Route::post('/addProj', 'TaskMasterController@addProj')->name('addProj');
    Route::post('/editProj', 'TaskMasterController@editProj')->name('editProj');
    Route::post('/saveEditProj', 'TaskMasterController@saveEditProj')->name('saveEditProj');
    Route::post('/destroyProj', 'TaskMasterController@destroyProj')->name('destroyProj');

	Route::get('/viewTasks/{id}','TaskMasterController@viewTasks')->name('viewTasks');
    Route::get('/task_dtb/{id}', 'TaskMasterController@task_dtb')->name('task_dtb');

    Route::post('/addTask', 'TaskMasterController@addTask')->name('addTask');
    Route::post('/editTask', 'TaskMasterController@editTask')->name('editTask');
    Route::post('/saveEditTask', 'TaskMasterController@saveEditTask')->name('saveEditTask');
    Route::post('/destroyTask', 'TaskMasterController@destroyTask')->name('destroyTask');
    

    //update on first visit
    Route::post('/updateUserDetails', 'TaskMasterController@updateUserDetails')->name('updateUserDetails');
    
    //passwords
    Route::get('/changePassword', 'TaskMasterController@changePassword')->name('changePasswordTaskMaster');
    Route::post('/', 'TaskMasterController@savePassword')->name('savePasswordTaskMaster');

    Route::get('/viewProfile', 'TaskMasterController@viewProfile')->name('viewProfile');
    Route::post('/editProfile', 'TaskMasterController@editProfile')->name('editProfileTaskMaster');


});
