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


Route::get('/', 'MapController@index')->name('map');
Route::get('/businesses/{id}', 'BusinessController@view')->name('map.business.view');

Route::prefix('admin')
    ->middleware('auth')
    ->middleware('can:accessAdmin')
    ->namespace('Admin')
    ->group(function () {
        Route::get('/', 'AdminController@index')->name('admin.index');
        Route::get('business/validate-field', 'BusinessController@validateField')->name('admin.business.validate-field');
        Route::get('business/scrape-review', 'BusinessController@scrapeReview')->name('admin.business.scrape-review');
        Route::get('business/from-submission/{id}', 'BusinessController@createFromSubmission')->name('admin.business.createFromSubmission');
        Route::get('business/{id?}', 'BusinessController@edit')->name('admin.business.edit');
        Route::post('business', 'BusinessController@create')->name('admin.business.create');
        Route::put('business/{id}', 'BusinessController@update')->name('admin.business.update');
        Route::delete('business/{id}', 'BusinessController@delete')->name('admin.business.delete');
        Route::get('submissions', 'SubmissionController@index')->name('admin.submissions.index');
        Route::get('submissions/{id}', 'SubmissionController@view')->name('admin.submissions.view');
    });

