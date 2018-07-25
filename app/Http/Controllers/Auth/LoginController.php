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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * [validateLogin description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    protected function validateLogin(\Illuminate\Http\Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|exists:users,' . $this->username() . ',status,1',
            'password' => 'required',
        ]);
    }



    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function redirectTo()
    {
        // if user have role
        if (auth()->user()->access_id == 1) // Admin
        {
            return $this->redirectTo = '/';
        }
        elseif(auth()->user()->access_id == 3) // finance
        {
            return $this->redirectTo = '/finance';            
        }
        
        return $this->redirectTo = '/';
    }
}
