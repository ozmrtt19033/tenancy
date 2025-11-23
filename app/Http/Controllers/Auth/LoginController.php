<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
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
    protected $redirectTo = RouteServiceProvider::HOME;

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
     * Handle a login request to the application.
     * Tenant context'inde çalıştığından emin ol
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(\Illuminate\Http\Request $request)
    {
        // DEBUG: Tenancy ve database durumunu logla
        try {
            $currentDB = \DB::connection()->getDatabaseName();
            \Log::info('LoginController - Current Database: ' . $currentDB);
            \Log::info('LoginController - Tenancy Initialized: ' . (tenancy()->initialized ? 'Yes' : 'No'));
            if (function_exists('tenant') && tenant()) {
                \Log::info('LoginController - Tenant ID: ' . tenant('id'));
            }
            \Log::info('LoginController - Default Connection: ' . config('database.default'));
        } catch (\Exception $e) {
            \Log::error('LoginController - Debug Error: ' . $e->getMessage());
        }
        
        // Tenant context'inin aktif olduğundan emin ol
        if (!tenancy()->initialized) {
            return redirect()->route('home')
                ->with('error', 'Bu işlem sadece tenant domain\'lerinde yapılabilir. Lütfen bir tenant domain\'ine gidin.');
        }

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            // Tenant ID'yi session'a ekle - tenant izolasyonu için
            $request->session()->put('tenant_id', tenant('id'));
            
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
}
