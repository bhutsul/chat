<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/create', function () {
    return view('pages.create-group');
})->name('create');
Route::get('/search', function () {
    return view('pages.search-groups');
})->name('search');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/group/{id}', 'Pages\GroupController@index');
Route::get('/group/{id}/messages', 'Pages\GroupController@fetchMessages');
Route::get('/group/{id}/edit', 'Pages\GroupController@edit')->middleware('group');
Route::get('/myGroups', 'Pages\GroupController@showMyGroups')->name('showMyGroups');
Route::get('/allGroups', 'Pages\GroupController@showAllGroups')->name('showAllGroups');
Route::post('/messages', 'Pages\GroupController@sendMessage');
Route::post('/create', 'Pages\GroupController@create');
Route::post('/searchGroups', 'Pages\GroupController@search');
Route::post('/joinGroup', 'Pages\GroupController@joinGroup');
Route::put('/updateGroup', 'Pages\GroupController@update');
Route::put('/deleteGroup', 'Pages\GroupController@delete');
Route::put('/kickUser', 'Pages\GroupController@kickUser');

Route::post('/searchUser', 'UserController@search');

Route::post('/inviteUser', 'Pages\Invitations@invite');
Route::get('/invitations', 'Pages\Invitations@index')->name('invitations');
Route::put('/invitations/delete', 'Pages\Invitations@delete');
Route::put('/invitations/confirm', 'Pages\Invitations@confirm');

Route::get('/requests', 'Pages\RequestsController@index')->name('requests');
Route::post('/requestGroup', 'Pages\RequestsController@requestGroup');
Route::put('/requests/delete', 'Pages\RequestsController@delete');
Route::put('/requests/confirm', 'Pages\RequestsController@confirm');
