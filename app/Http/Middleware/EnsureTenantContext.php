<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureTenantContext
{
    /**
     * Handle an incoming request.
     * Merkezi domain'de users tablosuna erişimi engelle
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Tenant context kontrolü
        if (!tenancy()->initialized) {
            // Merkezi domain'deyiz, users tablosuna erişim yasak
            $route = $request->route();
            $action = $route ? $route->getAction() : [];
            
            // User model'i kullanan route'ları kontrol et
            if (isset($action['controller'])) {
                $controller = $action['controller'];
                
                // Auth controller'ları veya User controller'ı
                if (strpos($controller, 'Auth\\') !== false || 
                    strpos($controller, 'UserController') !== false ||
                    $request->routeIs('login') ||
                    $request->routeIs('register') ||
                    $request->routeIs('users.*')) {
                    
                    return redirect()->route('home')
                        ->with('error', 'Bu işlem sadece tenant domain\'lerinde yapılabilir. Lütfen bir tenant domain\'ine gidin.');
                }
            }
        }

        return $next($request);
    }
}

