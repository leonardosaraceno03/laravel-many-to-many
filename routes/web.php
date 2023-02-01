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


Auth::routes();

//Qui dobbiamo creare un modo per gestire le rotte sotto autenticazione
Route::middleware('auth')
    ->namespace('Admin')
    ->prefix('admin') //localhost:8080/admin/posts
    ->name('admin.')
    ->group(function(){
        Route::get('/', 'HomeController@index')->name('index');
        //controllers per crud
        Route::resource('/post', PostController::class);
});

//Qui dobbiamo trovare un  modo per gestire tutte le rotte che non usano autenticazione
Route::get('{any?}', function(){
    return view('guest.home');
})->where("any", ".*");
