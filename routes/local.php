<?php

use App\Providers\RouteServiceProvider;
use TheRestartProject\Fixometer\Domain\Repositories\UserRepository;

/*Route::get('/', function (UserRepository $repository) {
    $users = $repository->findAll();
    $loggedInUser = Auth::user();
    return view(RouteServiceProvider::HOME, compact('users', 'loggedInUser'));
    })->name(RouteServiceProvider::HOME);*/

/*Route::namespace('Auth')
    ->group(function () {
        Route::get('/login', 'LoginController@showLoginForm')->name('login');
        Route::post('/login', 'LoginController@login');
        Route::get('/logout', 'LoginController@logout')->name('logout');
        });*/
