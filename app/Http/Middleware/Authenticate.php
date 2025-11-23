<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, \Closure $next, ...$guards)
    {
        // Tenant context kontrolü
        if (tenancy()->initialized && Auth::check()) {
            $sessionTenantId = $request->session()->get('tenant_id');
            $currentTenantId = tenant('id');
            
            // Session'daki tenant ID ile mevcut tenant ID eşleşmiyorsa logout yap
            if ($sessionTenantId && $sessionTenantId !== $currentTenantId) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return redirect()->route('login')
                    ->with('error', 'Bu kullanıcı bu tenant için geçerli değil. Lütfen tekrar giriş yapın.');
            }
        }

        return parent::handle($request, $next, ...$guards);
    }
}
