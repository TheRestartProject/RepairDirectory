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

Route::get('/', function () {
    $environment = app()->environment();
    return view('welcome', compact('environment'));
});

Route::prefix('admin')
    ->namespace('Admin')
    ->group(function () {
        Route::get('/', 'AdminController@index')->name('admin.index');

        Route::get('business/new', 'BusinessController@create')->name('admin.business.new');
        Route::post('business', 'BusinessController@store')->name('admin.business.store');

        Route::get('business/{id}', 'BusinessController@show')->name('admin.business.show');
        Route::put('business/{id}', 'BusinessController@update')->name('admin.business.update');
    });

