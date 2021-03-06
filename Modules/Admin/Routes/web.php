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
    Route::get('/TaskTypes', 'AdminController@viewTaskTypes')->name('viewTaskTypes')->middleware('admin');
    Route::get('/Projects', 'AdminController@viewProjects')->name('viewProjects')->middleware('admin');
    Route::get('/ProjectTasks/{id}', 'AdminController@viewProjectTasks')->name('viewProjectTasks');

    Route::get('/tasks', 'AdminController@viewTask')->name('viewTask')->middleware('admin');
    Route::post('/AddUser', 'AdminController@addUser')->name('addUser')->middleware('admin');
    Route::post('/addTaskType', 'AdminController@addTaskType')->name('addTaskType')->middleware('admin');
    Route::get('/user_profile/{id}', 'AdminController@viewUser')->name('viewUser')->middleware('admin');
    Route::post('/taskDetails', 'AdminController@taskDetails')->name('taskDetailsAdmin');


    Route::post('/viewUserDetails', 'AdminController@viewUserDetails')->name('viewUserDetails')->middleware('admin');
    Route::get('/people_dtb', 'AdminController@usersShow')->name('usersShow')->middleware('admin');
    Route::get('/task_dtb', 'AdminController@taskShow')->name('taskShow')->middleware('admin');
    Route::get('/tasks_dtb/{id}', 'AdminController@tasksShow')->name('tasksShow')->middleware('admin');

    Route::get('/project_dtb', 'AdminController@projectShow')->name('projectShow')->middleware('admin');

    Route::post('/storeAdd', 'AdminController@storeAdd')->name('storeAdd')->middleware('admin');
    Route::post('/editUser', 'AdminController@editUser')->name('editUser')->middleware('admin');
    Route::post('/saveEditUser', 'AdminController@saveEditUser')->name('saveEditUser')->middleware('admin');
    Route::post('/destroyUser', 'AdminController@destroyUser')->name('destroyUser')->middleware('admin');
    Route::post('/destroyType', 'AdminController@destroyType')->name('destroyType')->middleware('admin');

    Route::post('/editTaskType', 'AdminController@editTaskType')->name('editTaskType')->middleware('admin');
    Route::post('/updateTaskType', 'AdminController@updateTaskType')->name('updateTaskType')->middleware('admin');

    Route::get('/adduser', 'AdminController@adduser')->name('adduser')->middleware('admin');
    Route::get('/changePassword', 'AdminController@changePassword')->name('changePassword')->middleware('admin');
    Route::post('/', 'AdminController@savePassword')->name('savePassword')->middleware('admin');

    
    Route::get('/viewProfile', 'AdminController@viewProfileAdmin')->name('viewProfileAdmin')->middleware('admin');
    Route::post('/editProfile', 'AdminController@editProfileAdmin')->name('editProfileAdmin')->middleware('admin');
    Route::post('/storeProfile', 'AdminController@storeProfileAdmin')->name('storeProfileAdmin');

    Route::get('/viewReport', 'AdminController@viewReport')->name('viewAdminReport');
    Route::get('/usersShowReport', 'AdminController@usersShowReport')->name('usersShowReport');
    Route::post('/userReport', 'AdminController@userReport')->name('userReportPDF');
});
