<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if($user->active == 0){
                Auth::logout();
                return redirect("login")->with('error','Please wait for admin to activate your account');
            }else if($user->active == 2){
                Auth::logout();
                return redirect("login")->with('error','Your account has been deactivated please ask an admin to reactiavte your account');
            }else if($user->active == 1){
                Auth::login($user);
                return redirect()->route('welcome')
                            ->withSuccess('You have Successfully loggedin');
            }
        }

        return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');

    }
}
