<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        // Merkezi domain'de users tablosuna erişim hatası
        if ($e instanceof \Illuminate\Database\QueryException) {
            $message = $e->getMessage();
            
            // SQL sorgusunu al
            $sql = '';
            try {
                if (method_exists($e, 'getSql')) {
                    $sql = $e->getSql() ?? '';
                } elseif (method_exists($e, 'getQuery')) {
                    $sql = $e->getQuery() ?? '';
                }
            } catch (\Exception $sqlException) {
                // SQL alınamazsa mesajdan çıkar
                if (preg_match('/SQL: (.+)/', $message, $matches)) {
                    $sql = $matches[1] ?? '';
                }
            }
            
            // Users tablosu ile ilgili hatalar - daha kapsamlı kontrol
            $isUsersTableError = (
                strpos($message, "Table 'tenancy_central.users' doesn't exist") !== false ||
                strpos($message, "Base table or view not found: 1146") !== false ||
                strpos($message, "tenant_users_not_available_in_central") !== false ||
                (strpos($message, "doesn't exist") !== false && (strpos($message, 'users') !== false || strpos($sql, 'users') !== false || strpos($sql, '`users`') !== false || strpos($sql, ' from `users`') !== false)) ||
                (strpos($message, "1146") !== false && (strpos($message, 'users') !== false || strpos($sql, 'users') !== false || strpos($sql, '`users`') !== false || strpos($sql, ' from `users`') !== false)) ||
                (strpos($message, "42S02") !== false && (strpos($message, 'users') !== false || strpos($sql, 'users') !== false || strpos($sql, '`users`') !== false || strpos($sql, ' from `users`') !== false))
            );
            
            if ($isUsersTableError) {
                // Merkezi domain kontrolü - daha güvenli kontrol
                $isCentral = $this->isCentralDomain($request);
                
                if ($isCentral) {
                    try {
                        return response()->view('errors.tenant-required', [
                            'message' => 'Bu işlem sadece tenant domain\'lerinde yapılabilir.',
                            'hint' => 'Lütfen bir tenant domain\'ine gidin (örn: mycompany.localhost:8004)'
                        ], 403);
                    } catch (\Exception $viewException) {
                        // View yüklenemezse basit bir mesaj döndür
                        return response('Bu işlem sadece tenant domain\'lerinde yapılabilir. Lütfen bir tenant domain\'ine gidin.', 403);
                    }
                }
            }
        }

        return parent::render($request, $e);
    }

    /**
     * Merkezi domain kontrolü
     *
     * @param  \Illuminate\Http\Request|null  $request
     * @return bool
     */
    protected function isCentralDomain($request = null)
    {
        try {
            // Önce tenancy helper'ını kontrol et
            if (function_exists('tenancy')) {
                $tenancy = tenancy();
                if ($tenancy && method_exists($tenancy, 'initialized')) {
                    return !$tenancy->initialized;
                }
            }
            
            // Alternatif: tenant() helper'ını kontrol et
            if (function_exists('tenant')) {
                $tenant = tenant();
                return $tenant === null;
            }
            
            // Son çare: request'ten domain kontrolü
            if (!$request) {
                $request = request();
            }
            
            if ($request) {
                $host = $request->getHost();
                $centralDomains = config('tenancy.central_domains', ['127.0.0.1', 'localhost']);
                // Eğer host merkezi domain'lerden biri ise, merkezi domain'dir
                return in_array($host, $centralDomains);
            }
            
            return true; // Request yoksa merkezi domain olduğunu varsay
        } catch (\Exception $e) {
            // Hata varsa merkezi domain olduğunu varsay
            return true;
        }
    }
}
