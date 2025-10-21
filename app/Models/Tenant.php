<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'data',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Tenant veritabanı adını döndür
     * Örn: tenantacme, tenanttest
     */
    public function getTenancyDbNameAttribute(): string
    {
        return config('tenancy.database.prefix', 'tenant') . $this->id . config('tenancy.database.suffix', '');
    }

    /**
     * Tenant veritabanı kullanıcı adını döndür (MySQL için)
     */
    public function getTenancyDbUsernameAttribute(): string
    {
        return config('database.connections.mysql.username');
    }

    /**
     * Tenant veritabanı şifresini döndür (MySQL için)
     */
    public function getTenancyDbPasswordAttribute(): string
    {
        return config('database.connections.mysql.password');
    }
}
