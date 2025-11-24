<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Handle a registration request for the application.
     * Tenant context'inde çalıştığından emin ol
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(\Illuminate\Http\Request $request)
    {
        // Tenant context kontrolü
        $isTenantContext = false;
        
        if (function_exists('tenancy') && tenancy()->initialized) {
            $isTenantContext = true;
        } else {
            // Domain kontrolü
            try {
                $host = $request->getHost();
                $centralDomains = config('tenancy.central_domains', ['127.0.0.1', 'localhost']);
                if (!in_array($host, $centralDomains)) {
                    $tenant = \App\Models\Tenant::whereHas('domains', function($query) use ($host) {
                        $query->where('domain', $host);
                    })->first();
                    if ($tenant) {
                        $isTenantContext = true;
                    }
                }
            } catch (\Exception $e) {
                // Hata durumunda
            }
        }
        
        if (!$isTenantContext) {
            return redirect()->route('home')
                ->with('error', 'Kayıt işlemi sadece tenant domain\'lerinde yapılabilir. Lütfen bir tenant domain\'ine gidin.');
        }

        $this->validator($request->all())->validate();

        event(new \Illuminate\Auth\Events\Registered($user = $this->create($request->all())));

        \Illuminate\Support\Facades\Auth::guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
                    ? new \Illuminate\Http\JsonResponse([], 201)
                    : redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // User model'i zaten doğru connection'ı kullanacak
        // Validation'da User model üzerinden kontrol et
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                function ($attribute, $value, $fail) {
                    // User model üzerinden kontrol et - getConnection() otomatik çağrılacak
                    if (User::where('email', $value)->exists()) {
                        $fail('Bu email adresi zaten kullanılıyor.');
                    }
                }
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
