<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The connection name for the model.
     * Bu dinamik olarak tenant database'e göre ayarlanacak
     *
     * @var string|null
     */
    protected $connection = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();
    }

    /**
     * Get the database connection for the model.
     *
     * @return \Illuminate\Database\Connection
     */
    public function getConnection()
    {
        // Static cache - aynı request içinde tekrar çağrılmaması için
        static $cachedConnection = null;
        static $cachedTenantId = null;
        
        // Önce tenant() helper'ını dene
        $tenantId = null;
        if (function_exists('tenant')) {
            try {
                $tenant = tenant();
                if ($tenant) {
                    $tenantId = $tenant->id ?? null;
                }
            } catch (\Exception $e) {
                // Tenant helper hatası, domain'den bulacağız
                \Log::error('User getConnection - tenant() helper error: ' . $e->getMessage());
            }
        }
        
        // Eğer tenant ID bulunamadıysa, domain'den bul
        if (!$tenantId) {
            try {
                $request = request();
                if ($request) {
                    $host = $request->getHost();
                    $centralDomains = config('tenancy.central_domains', ['127.0.0.1', 'localhost']);
                    
                    // Eğer merkezi domain değilse, domain'den tenant'ı bul
                    if (!in_array($host, $centralDomains)) {
                        // Merkezi veritabanından tenant'ı bul (connection kullanmadan)
                        try {
                            $domain = DB::connection('mysql')
                                ->table('domains')
                                ->where('domain', $host)
                                ->first();
                            
                            if ($domain) {
                                $tenantId = $domain->tenant_id;
                            }
                        } catch (\Exception $e) {
                            \Log::error('User getConnection - domain lookup error: ' . $e->getMessage());
                        }
                    }
                }
            } catch (\Exception $e) {
                \Log::error('User getConnection - request error: ' . $e->getMessage());
            }
        }
        
        // Cache kontrolü - aynı tenant ID için cache'lenmiş connection varsa onu kullan
        if ($tenantId && $cachedTenantId === $tenantId && $cachedConnection) {
            $this->connection = $cachedConnection->getName();
            return $cachedConnection;
        }
        
        // Tenant ID bulunduysa, connection oluştur
        if ($tenantId) {
            $dbName = 'tenant' . $tenantId;
            $connectionName = 'tenant_' . $tenantId;
            
            try {
                // Eğer bu connection daha önce oluşturulmamışsa, oluştur
                $connections = Config::get('database.connections', []);
                if (!isset($connections[$connectionName])) {
                    Config::set('database.connections.' . $connectionName, [
                        'driver' => 'mysql',
                        'host' => env('DB_HOST', '127.0.0.1'),
                        'port' => env('DB_PORT', '3306'),
                        'database' => $dbName,
                        'username' => env('DB_USERNAME', 'root'),
                        'password' => env('DB_PASSWORD', ''),
                        'charset' => 'utf8mb4',
                        'collation' => 'utf8mb4_unicode_ci',
                        'prefix' => '',
                        'strict' => true,
                        'engine' => null,
                    ]);
                    
                    // Connection'ı yeniden yükle
                    DB::purge($connectionName);
                }
                
                // Connection'ı al
                $connection = DB::connection($connectionName);
                
                // Cache'le
                $cachedConnection = $connection;
                $cachedTenantId = $tenantId;
                
                // Bu connection'ı kullan
                $this->connection = $connectionName;
                
                return $connection;
            } catch (\Exception $e) {
                \Log::error('User getConnection - connection creation error: ' . $e->getMessage());
                \Log::error('User getConnection - Stack trace: ' . $e->getTraceAsString());
                
                // Hata durumunda merkezi domain hatası ver
                $pdoException = new \PDOException("Failed to connect to tenant database: " . $e->getMessage());
                $pdoException->errorInfo = ['42S02', 1146, "Table 'tenancy_central.users' doesn't exist"];
                
                throw new \Illuminate\Database\QueryException(
                    'select * from `users`',
                    [],
                    $pdoException
                );
            }
        }
        
        // Tenant yoksa (merkezi domain), hata ver
        $pdoException = new \PDOException("Table 'tenancy_central.users' doesn't exist");
        $pdoException->errorInfo = ['42S02', 1146, "Table 'tenancy_central.users' doesn't exist"];
        
        throw new \Illuminate\Database\QueryException(
            'select * from `users`',
            [],
            $pdoException
        );
    }
}
