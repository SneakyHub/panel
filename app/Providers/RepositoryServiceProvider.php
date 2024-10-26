<?php

namespace sneakypanel\Providers;

use Illuminate\Support\ServiceProvider;
use sneakypanel\Repositories\Eloquent\EggRepository;
use sneakypanel\Repositories\Eloquent\NestRepository;
use sneakypanel\Repositories\Eloquent\NodeRepository;
use sneakypanel\Repositories\Eloquent\TaskRepository;
use sneakypanel\Repositories\Eloquent\UserRepository;
use sneakypanel\Repositories\Eloquent\ApiKeyRepository;
use sneakypanel\Repositories\Eloquent\ServerRepository;
use sneakypanel\Repositories\Eloquent\SessionRepository;
use sneakypanel\Repositories\Eloquent\SubuserRepository;
use sneakypanel\Repositories\Eloquent\DatabaseRepository;
use sneakypanel\Repositories\Eloquent\LocationRepository;
use sneakypanel\Repositories\Eloquent\ScheduleRepository;
use sneakypanel\Repositories\Eloquent\SettingsRepository;
use sneakypanel\Repositories\Eloquent\AllocationRepository;
use sneakypanel\Contracts\Repository\EggRepositoryInterface;
use sneakypanel\Repositories\Eloquent\EggVariableRepository;
use sneakypanel\Contracts\Repository\NestRepositoryInterface;
use sneakypanel\Contracts\Repository\NodeRepositoryInterface;
use sneakypanel\Contracts\Repository\TaskRepositoryInterface;
use sneakypanel\Contracts\Repository\UserRepositoryInterface;
use sneakypanel\Repositories\Eloquent\DatabaseHostRepository;
use sneakypanel\Contracts\Repository\ApiKeyRepositoryInterface;
use sneakypanel\Contracts\Repository\ServerRepositoryInterface;
use sneakypanel\Repositories\Eloquent\ServerVariableRepository;
use sneakypanel\Contracts\Repository\SessionRepositoryInterface;
use sneakypanel\Contracts\Repository\SubuserRepositoryInterface;
use sneakypanel\Contracts\Repository\DatabaseRepositoryInterface;
use sneakypanel\Contracts\Repository\LocationRepositoryInterface;
use sneakypanel\Contracts\Repository\ScheduleRepositoryInterface;
use sneakypanel\Contracts\Repository\SettingsRepositoryInterface;
use sneakypanel\Contracts\Repository\AllocationRepositoryInterface;
use sneakypanel\Contracts\Repository\EggVariableRepositoryInterface;
use sneakypanel\Contracts\Repository\DatabaseHostRepositoryInterface;
use sneakypanel\Contracts\Repository\ServerVariableRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register all the repository bindings.
     */
    public function register(): void
    {
        // Eloquent Repositories
        $this->app->bind(AllocationRepositoryInterface::class, AllocationRepository::class);
        $this->app->bind(ApiKeyRepositoryInterface::class, ApiKeyRepository::class);
        $this->app->bind(DatabaseRepositoryInterface::class, DatabaseRepository::class);
        $this->app->bind(DatabaseHostRepositoryInterface::class, DatabaseHostRepository::class);
        $this->app->bind(EggRepositoryInterface::class, EggRepository::class);
        $this->app->bind(EggVariableRepositoryInterface::class, EggVariableRepository::class);
        $this->app->bind(LocationRepositoryInterface::class, LocationRepository::class);
        $this->app->bind(NestRepositoryInterface::class, NestRepository::class);
        $this->app->bind(NodeRepositoryInterface::class, NodeRepository::class);
        $this->app->bind(ScheduleRepositoryInterface::class, ScheduleRepository::class);
        $this->app->bind(ServerRepositoryInterface::class, ServerRepository::class);
        $this->app->bind(ServerVariableRepositoryInterface::class, ServerVariableRepository::class);
        $this->app->bind(SessionRepositoryInterface::class, SessionRepository::class);
        $this->app->bind(SettingsRepositoryInterface::class, SettingsRepository::class);
        $this->app->bind(SubuserRepositoryInterface::class, SubuserRepository::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }
}
