<?php

namespace sneakypanel\Facades;

use Illuminate\Support\Facades\Facade;
use sneakypanel\Services\Activity\ActivityLogService;

class Activity extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ActivityLogService::class;
    }
}
