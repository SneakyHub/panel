<?php

namespace sneakypanel\Providers;

use Laravel\Sanctum\Sanctum;
use sneakypanel\Models\ApiKey;
use sneakypanel\Models\Server;
use sneakypanel\Policies\ServerPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     */
    protected $policies = [
        Server::class => ServerPolicy::class,
    ];

    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(ApiKey::class);
    }
}
