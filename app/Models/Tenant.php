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
     * Doldurulabilir alanlar
     */
    protected $fillable = [
        'id',
        'data',
    ];

    /**
     * JSON olarak cast edilecek alanlar
     */
    protected $casts = [
        'data' => 'array',
    ];
}
