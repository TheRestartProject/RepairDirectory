<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('api')
    ->namespace('Api')
    ->group(function () {
        Route::get('business/search', 'BusinessController@search')->name('business.search');
        Route::get('category/list', 'CategoryController@list')->name('category.list');
        Route::get('suggestion/search', 'SuggestionController@search')->name('suggestion.search');
        Route::post('suggestion/add', 'SuggestionController@add')->name('suggestion.add');
    });
