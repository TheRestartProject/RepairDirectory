<?php

use TheRestartProject\RepairDirectory\Domain\Repositories\UserRepository;

Route::get('/', function (UserRepository $repository) {
    $users = $repository->findAll();
    return view('home', compact('users'));
})->name('home');

Route::namespace('Auth')
    ->group(function () {
        Route::get('/login', 'LoginController@showLoginForm')->name('login');
        Route::post('/login', 'LoginController@login');
        Route::get('/logout', 'LoginController@logout')->name('logout');
    });
