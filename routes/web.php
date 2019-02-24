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

Route::get('/', 'StudyController@welcome')->name('index page');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('file_upload/file/upload','FileUploadController@fileCreate');
Route::post('file_upload/file/upload/store','FileUploadController@fileStore');
Route::post('file_upload/file/delete','FileUploadController@fileDestroy');
Route::get('/zipcreate','FileUploadController@zipcreate');
Route::get('/zipcreate','FileUploadController@zipcreate_test');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');



Route::get('studies/create_study', 'StudyController@create_study')->name('create study')->middleware('login_check');
Route::post('studies/post_study', 'StudyController@post_study')->name('post study')->middleware('login_check');

Route::get('studies/my_studies', 'StudyController@my_studies')->name('my studies')->middleware('login_check');

Route::get('/datesets', 'StudyController@datasets')->name('my studies');
Route::get('/go_to_study_page', 'StudyController@go_to_study_page')->name('ajax call study page');
Route::get('/create_dataset', 'StudyController@create_dataset')->name('create dataset');

Route::get('/go_to_files', 'StudyController@go_to_files')->name('ajax call for files');
Route::get('/create_folder', 'StudyController@create_folder')->name('ajax call to create folder');
Route::get('/contents', 'StudyController@contents')->name('contents');
Route::get('/back_pressed', 'StudyController@back_pressed')->name('back pressed');

Route::get('/check_for_filename', 'FileUploadController@check_for_filename')->name('ajax call to check file name');
