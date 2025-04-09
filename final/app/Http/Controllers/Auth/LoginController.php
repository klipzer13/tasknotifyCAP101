<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function redirectTo()
    {
        if (\Illuminate\Support\Facades\Auth::check()) {
            $roleId = \Illuminate\Support\Facades\Auth::user()->role->id ?? null;
            switch ($roleId) {
                case 1:
                    return '/admin/dashboard';
                case 2:
                    return '/chairperson/dashboard';
                case 3:
                    return '/employee/dashboard';
                default:
                    return '/home';
            }
        }

        return '/home';
    }
    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
