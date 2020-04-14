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
Route::get('/invitations', function () {
    return view('pages.group-invitations');
})->name('invitations');
Route::get('/show', 'Pages\GroupController@show')->name('show');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/group/{id}', 'Pages\GroupController@index');
Route::get('/group/{id}/messages', 'Pages\GroupController@fetchMessages');
Route::post('/messages', 'Pages\GroupController@sendMessage');
