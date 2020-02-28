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
    Route::get('/', 'TaskMasterController@index')->name('taskmasterHome')->middleware('taskmaster');
    Route::get('/project_dtb', 'TaskMasterController@project_dtb')->name('project_dtb')->middleware('taskmaster');
    Route::post('/addProj', 'TaskMasterController@addProj')->name('addProj')->middleware('taskmaster');
    Route::post('/editProj', 'TaskMasterController@editProj')->name('editProj')->middleware('taskmaster');
    Route::post('/saveEditProj', 'TaskMasterController@saveEditProj')->name('saveEditProj')->middleware('taskmaster');
    Route::post('/destroyProj', 'TaskMasterController@destroyProj')->name('destroyProj')->middleware('taskmaster');

	Route::get('/viewTasks/{id}','TaskMasterController@viewTasks')->name('viewTasks')->middleware('taskmaster');
    Route::get('/task_dtb/{id}', 'TaskMasterController@task_dtb')->name('task_dtb')->middleware('taskmaster');

    Route::post('/addTask', 'TaskMasterController@addTask')->name('addTask')->middleware('taskmaster');
    Route::post('/editTask', 'TaskMasterController@editTask')->name('editTask')->middleware('taskmaster');
    Route::post('/saveEditTask', 'TaskMasterController@saveEditTask')->name('saveEditTask')->middleware('taskmaster');
    Route::post('/destroyTask', 'TaskMasterController@destroyTask')->name('destroyTask')->middleware('taskmaster');
    

    //update on first visit
    Route::post('/updateUserDetails', 'TaskMasterController@updateUserDetails')->name('updateUserDetails')->middleware('taskmaster');
    
    //passwords
    Route::get('/changePassword', 'TaskMasterController@changePassword')->name('changePasswordTaskMaster')->middleware('taskmaster');
    Route::post('/', 'TaskMasterController@savePassword')->name('savePasswordTaskMaster')->middleware('taskmaster');

    Route::get('/viewProfile', 'TaskMasterController@viewProfile')->name('viewProfile')->middleware('taskmaster');
    Route::post('/editProfile', 'TaskMasterController@editProfile')->name('editProfileTaskMaster')->middleware('taskmaster');

    Route::get('/projectReport', 'TaskMasterController@projectReport')->name('projectReport')->middleware('taskmaster');
    Route::get('/taskReport', 'TaskMasterController@taskReport')->name('taskReport')->middleware('taskmaster');

    Route::get('/viewTaskReport', 'TaskMasterController@viewTaskReport')->name('viewTaskReport')->middleware('taskmaster');
    Route::get('/taskReport_dtb', 'TaskMasterController@taskReport_dtb')->name('taskReport_dtb')->middleware('taskmaster');


});
