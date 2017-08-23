<?php

use Illuminate\Http\Request;
use TheRestartProject\RepairDirectory\Domain\Repositories\UserRepository;

Route::get('/', function (Request $request, UserRepository $repository) {
    $users = $repository->findAll();
    $loggedInUser = Auth::user();

    dd($request->cookies);

    return view('home', compact('users', 'loggedInUser'));
})->name('home');

Route::namespace('Auth')
    ->group(function () {
        Route::get('/login', 'LoginController@showLoginForm')->name('login');
        Route::post('/login', 'LoginController@login');
        Route::get('/logout', 'LoginController@logout')->name('logout');
    });
