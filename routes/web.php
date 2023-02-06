<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\MapController;
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


Route::get('/', [MapController::class, 'index'])->name('map');
Route::get('/businesses/{id}', [BusinessController::class, 'view'])->name('map.business.view');

Route::prefix('admin')
    ->middleware('auth')
    ->middleware('can:accessAdmin')
    ->group(function () {
        Route::get('/', [Admin\AdminController::class, 'index'])->name('admin.index');
        Route::get('business/validate-field', [Admin\BusinessController::class, 'validateField'])->name('admin.business.validate-field');
        Route::get('business/from-submission/{id}', [Admin\BusinessController::class, 'createFromSubmission'])->name('admin.business.createFromSubmission');
        Route::get('business/{id?}', [Admin\BusinessController::class, 'edit'])->name('admin.business.edit');
        Route::post('business', [Admin\BusinessController::class, 'create'])->name('admin.business.create');
        Route::put('business/{id}', [Admin\BusinessController::class, 'update'])->name('admin.business.update');
        Route::delete('business/{id}', [Admin\BusinessController::class, 'delete'])->name('admin.business.delete');
        Route::get('submissions', [Admin\SubmissionController::class, 'index'])->name('admin.submissions.index');
        Route::get('submissions/{id}', [Admin\SubmissionController::class, 'view'])->name('admin.submissions.view');
        Route::post('submissions/{id}', [Admin\SubmissionController::class, 'update'])->name('admin.submissions.update');
    });

