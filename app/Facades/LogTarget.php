<?php

namespace sneakypanel\Facades;

use Illuminate\Support\Facades\Facade;
use sneakypanel\Services\Activity\ActivityLogTargetableService;

class LogTarget extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ActivityLogTargetableService::class;
    }
}
