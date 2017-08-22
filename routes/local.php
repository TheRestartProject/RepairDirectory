<?php
Route::get('/', function () {
    return [];
})->name('home');

Route::namespace('Auth')
    ->group(function () {
        Route::get('/login', 'LoginController@showLoginForm')->name('login');
        Route::post('/login', 'LoginController@login');
        Route::get('/logout', 'LoginController@logout')->name('logout');
    });
