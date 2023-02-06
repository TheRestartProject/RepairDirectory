<?php

use App\Http\Controllers\Api;
use Illuminate\Support\Facades\Route;
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
    ->group(function () {
        Route::get('business/search', [Api\BusinessController::class, 'search'])->name('business.search');
        Route::get('category/list', [Api\CategoryController::class, 'list'])->name('category.list');
        Route::get('suggestion/search', [Api\SuggestionController::class, 'search'])->name('suggestion.search');
        Route::post('suggestion/add', [Api\SuggestionController::class, 'add'])->name('suggestion.add');
        Route::patch('submission/{id}/status/{status}', [Api\SubmissionController::class, 'status'])->name('suggestion.status');
    });
