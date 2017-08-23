<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return self
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectTo()
    {
        return route('map');
    }

    public function login(Request $request)
    {
        $this->validateRequest($request);

        $this->guard()->loginUsingId($request->get('user_id'));

        return redirect()->route('map');
    }

    public function showLoginForm()
    {
        return redirect()->route('home');
    }

    public function logout()
    {
        $this->guard()->logout();

        return redirect()->route('home');
    }

    /**
     * validates the Request for logging in
     *
     * @param Request $request The request
     */
    protected function validateRequest(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|integer'
        ]);
    }

    /**
     * Returns the current guard
     *
     * @return StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
