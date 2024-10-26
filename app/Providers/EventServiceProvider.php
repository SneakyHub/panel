<?php

namespace sneakypanel\Providers;

use sneakypanel\Models\User;
use sneakypanel\Models\Server;
use sneakypanel\Models\Subuser;
use sneakypanel\Models\EggVariable;
use sneakypanel\Observers\UserObserver;
use sneakypanel\Observers\ServerObserver;
use sneakypanel\Observers\SubuserObserver;
use sneakypanel\Observers\EggVariableObserver;
use sneakypanel\Listeners\Auth\AuthenticationListener;
use sneakypanel\Events\Server\Installed as ServerInstalledEvent;
use sneakypanel\Notifications\ServerInstalled as ServerInstalledNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     */
    protected $listen = [
        ServerInstalledEvent::class => [ServerInstalledNotification::class],
    ];

    protected $subscribe = [
        AuthenticationListener::class,
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        parent::boot();

        User::observe(UserObserver::class);
        Server::observe(ServerObserver::class);
        Subuser::observe(SubuserObserver::class);
        EggVariable::observe(EggVariableObserver::class);
    }
}
