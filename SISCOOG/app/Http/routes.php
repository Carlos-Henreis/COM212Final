<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/upload', 'TesteController@upload');
Route::post('/upload', 'TesteController@move');

Route::get('/', function () {
    return view('welcome');
});




Route::group(['middleware' => ['web']], function(){
    Route::auth();
    Route::get('/home', 'HomeController@index');

    Route::post('/home/group/create', 'HomeController@CreateGroups');
    Route::get('/home/group/{id}', 'HomeController@ShowGroup');
    Route::post('/home/group/updateNome', 'HomeController@updateNome');
    Route::post ('/home/group/delete', 'HomeController@removeGrupo');

    Route::get('home/group/{id}/Participantes', 'HomeController@ShowMember');

    Route::post('/home/group/insertmember','HomeController@insertMember');
    Route::get('select2-autocomplete-ajax', 'HomeController@dataAjax');
    Route::post ('/home/group/{id}/Participantes/remove', 'HomeController@removeMember');
    Route::post ('/home/group/{id}/Participantes/autoremove', 'HomeController@autoremoveMember');


    Route::post('/home/group/{id}/tarefas/insert', 'HomeController@insertPost');
    Route::post('/home/group/{id}/tarefas/update', 'HomeController@updatePost');
    Route::post('/home/group/{id}/tarefas/delete', 'HomeController@removePost');
    Route::post('/home/group/{id}/tarefas/atribuir', 'HomeController@atribuiPost');

    Route::post('/home/group/{id}/upload', ['as' => 'files.upload', 'uses' => 'HomeController@fileUpload']);
    Route::get('/home/group/{id}/download/{fileId}', ['as' => 'files.download', 'uses' => 'HomeController@fileDownload']);
    Route::get('/home/group/{id}/remover/{fileId}', ['as' => 'files.destroy', 'uses' => 'HomeController@fileDestroy']);


    
});



Route::group(['middleware' => ['web']], function () {
    //Login Routes...
    Route::get('/admin/login','AdminAuth\AuthController@showLoginForm');
    Route::post('/admin/login','AdminAuth\AuthController@login');
    Route::get('/admin/logout','AdminAuth\AuthController@logout');

    // Registration Routes...
    Route::get('admin/register', 'AdminAuth\AuthController@showRegistrationForm');
    Route::post('admin/register', 'AdminAuth\AuthController@register');

    Route::post('admin/password/email','AdminAuth\PasswordController@sendResetLinkEmail');
    Route::post('admin/password/reset','AdminAuth\PasswordController@reset');
    Route::get('admin/password/reset/{token?}','AdminAuth\PasswordController@showResetForm');

    Route::get('admin/edit','AdminController@edit');
    Route::put('admin/update', ['as' => 'admin.cruds.update', 'uses' => 'AdminController@update']);

    Route::get('/admin', 'AdminController@index');
});  


Route::group(['middleware' => ['web']], function () {
    //Login Routes...
    Route::get('/login','Auth\AuthController@showLoginForm');
    Route::post('/login','Auth\AuthController@login');
    Route::get('/logout','Auth\AuthController@logout');

    // Registration Routes...
    Route::get('register', 'Auth\AuthController@showRegistrationForm');
    Route::post('register', 'Auth\AuthController@register');

    Route::post('password/email','Auth\PasswordController@sendResetLinkEmail');
    Route::post('password/reset','Auth\PasswordController@reset');
    Route::get('password/reset/{token?}','Auth\PasswordController@showResetForm');

    Route::get('edit','HomeController@edit');
    Route::put('update', ['as' => 'cruds.update', 'uses' => 'HomeController@update']);

    Route::get('/home', 'HomeController@index');
});  