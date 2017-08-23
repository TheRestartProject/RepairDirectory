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

use TheRestartProject\RepairDirectory\Domain\Enums\Category;

Route::get('/', function () {
    return view('map', [ 'categories' => Category::values() ]);
})->name('map');

Route::prefix('admin')
    ->middleware('auth')
    ->namespace('Admin')
    ->group(function () {
        Route::get('/', 'AdminController@index')->name('admin.index');
        Route::get('business/scrape-review', 'BusinessController@scrapeReview')->name('admin.business.scrape-review');
        Route::get('business/{id?}', 'BusinessController@edit')->name('admin.business.edit');
        Route::post('business', 'BusinessController@create')->name('admin.business.create');
        Route::put('business/{id}', 'BusinessController@update')->name('admin.business.update');
    });


