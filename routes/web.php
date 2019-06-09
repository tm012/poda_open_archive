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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'StudyController@landing_page')->name('index page');

Route::get('/welcome', 'StudyController@welcome')->name('study page');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('file_upload/file/upload','FileUploadController@fileCreate');
Route::post('file_upload/file/upload/store','FileUploadController@fileStore');
Route::post('file_upload/file/delete','FileUploadController@fileDestroy');
#Route::get('/zipcreate','FileUploadController@zipcreate');
Route::get('/zipcreate','FileUploadController@zipcreate_test');
Route::post('/test_tm','FileUploadController@test_tm');
Route::post('/upload_key_file','FileUploadController@upload_key_file');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/search_home', 'StudyController@search_home');
Route::get('/search_home_with_param', 'StudyController@search_home_with_param');


Route::get('studies/create_study', 'StudyController@create_study')->name('create study')->middleware('login_check');

Route::get('studies/edit_study', 'StudyController@edit_study')->name('edit study')->middleware('login_check');
Route::get('studies/study_archived', 'StudyController@study_archived')->name('archived study')->middleware('login_check');



Route::post('studies/post_study', 'StudyController@post_study')->name('post study')->middleware('login_check');

Route::post('studies/post_edit_study', 'StudyController@post_edit_study')->name('post edit study')->middleware('login_check');

Route::get('/approval_rejection_study', 'StudyController@approval_rejection_study')->name('approval rejection study')->middleware('login_check');



Route::get('studies/my_studies', 'StudyController@my_studies')->name('my studies')->middleware('login_check');
Route::get('studies/approval_requests', 'StudyController@approval_requests')->name('Approval requests')->middleware('login_check');

Route::get('/datesets', 'StudyController@datasets')->name('my studies');
Route::get('/go_to_study_page', 'StudyController@go_to_study_page')->name('ajax call study page');
Route::get('/create_dataset', 'StudyController@create_dataset')->name('create dataset');

Route::get('/go_to_files', 'StudyController@go_to_files')->name('ajax call for files');
Route::get('/create_folder', 'StudyController@create_folder')->name('ajax call to create folder');
Route::get('/contents', 'StudyController@contents')->name('contents');
Route::get('/back_pressed', 'StudyController@back_pressed')->name('back pressed');

Route::get('/check_for_filename', 'FileUploadController@check_for_filename')->name('ajax call to check file name');
Route::get('/reg_result', 'StudyController@reg_result')->name('reg_result');

Route::get('/users_waiting', 'StudyController@users_waiting')->name('users_waiting')->middleware('login_check');
Route::get('/user_approval_rejection', 'StudyController@user_approval_rejection')->name('user_approval_rejection')->middleware('login_check');


Route::get('/dataset_file_upload_queue', 'FileUploadController@dataset_file_upload_queue')->name("File upload queue");
Route::get('/key_file_upload_queue', 'FileUploadController@key_file_upload_queue')->name("key file upload queue");
Route::get('/test_file_up_queue', 'FileUploadController@test_file_up_queue')->name("File upload queue");


Route::get('/smart_search', 'StudyController@smart_search')->name("Smart Search");

Route::get('/partial_view_smart_search_drops', 'StudyController@partial_view_smart_search_drops')->name("Partial view dropdowns");
Route::post('/submit_final_smart_search', 'StudyController@submit_final_smart_search')->name("Partial view dropdowns");

Route::get('/test', 'FileUploadController@test')->name("testing things");
Route::get('/update_signed_url', 'FileUploadController@update_signed_url')->name("update signed url");

Route::get('/permanently_delete_data', 'StudyController@permanently_delete_data')->name("permanently_delete_data");
// Route::get('/smart_search_zip_creation', 'FileUploadController@smart_search_zip_creation')->name("smart_search_zip_creation");
Route::get('/set_breadcrumb_path', 'StudyController@set_breadcrumb_path')->name("set_breadcrumb_path");


$router->get('/smart_search_zip_creation/{files_string}',[
    'uses' => 'FileUploadController@smart_search_zip_creation',
    'as'   => 'switch'
]);

// https://stackoverflow.com/questions/34810479/how-to-pass-value-inside-href-to-laravel-controller

Route::get('studies/tasks', 'StudyController@tasks')->name("tasks")->middleware('admin_check');
Route::post('/post_task', 'StudyController@post_task')->name("post_task")->middleware('admin_check');
Route::get('/edit_task_name', 'StudyController@edit_task_name')->name("edit_task_name")->middleware('admin_check');
Route::get('/delete_task_name', 'StudyController@delete_task_name')->name("delete_task_name")->middleware('admin_check');
// Route::get('files/{file_name}', function($file_name = null)
// {
//     $path = storage_path().'/'.'app'.'/files/'.$file_name;
//     if (file_exists($path)) {
//         return Response::download($path);
//     }
// });