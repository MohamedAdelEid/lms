<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


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
    protected $redirectTo = '/treasure_academy/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function username(): string
    {
        return 'email';
    }
    public function login(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the user
        $credentials = $request->only($this->username(), 'password');
        if (Auth::attempt($credentials)) {
            // Check if the user is blocked
            if (Auth::user()->is_blocked == 1) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Your account is blocked.');
            }
            // If the user is not blocked, redirect them to the intended page
            return redirect()->intended($this->redirectTo);
        }

        // If authentication fails, display the default error message
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->forget('guard.web');

        return redirect()->route('login');
    }

}
