<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'Home\IndexController@index');
Route::get('/list/{cate_id}', 'Home\IndexController@listPage');
Route::get('/a/{art_id}', 'Home\IndexController@newsPage');

Route::group(['middleware'=> ['web','admin.login'],'prefix'=>'admin','namespace'=>'Admin'],function () {
    Route::get('/', 'IndexController@index');
    Route::get('info', 'IndexController@info');
    Route::get('quit', 'LoginController@quit');
    Route::any('password', 'IndexController@password');

    Route::post('cate/changeorder', 'CategoryController@changeOrder');
    Route::resource('category','CategoryController');

    Route::resource('article','ArticleController');

    Route::resource('links','LinksController');
    Route::post('links/changeorder', 'LinksController@changeOrder');

    Route::resource('navs','NavsController');
    Route::post('navs/changeorder', 'NavsController@changeOrder');

    Route::resource('config','ConfigController');
    Route::post('config/changeorder', 'ConfigController@changeOrder');
    Route::post('config/changecontent', 'ConfigController@changeContent');
    Route::get('putfile', 'ConfigController@putFile');

    Route::any('upload', 'CommonController@upload');

});

Route::any('admin/login', 'Admin\LoginController@login');
Route::get('admin/code', 'Admin\LoginController@code');
Route::get('admin/crypt', 'Admin\LoginController@crypt');
Route::get('admin/getcode', 'Admin\LoginController@getcode');

// 在这一行下面
Route::get('admin/upload', 'Admin\UploadController@index');

// 添加如下路由
Route::post('admin/upload/file', 'Admin\UploadController@uploadFile');
Route::delete('admin/upload/file', 'Admin\UploadController@deleteFile');
Route::post('admin/upload/folder', 'Admin\UploadController@createFolder');
Route::delete('admin/upload/folder', 'Admin\UploadController@deleteFolder');

Route::any('admin/file', 'Admin\FileController@file');
Route::any('admin/file_pro', 'Admin\FileController@file_pro');
Route::any('admin/file_list', 'Admin\FileController@file_pro');