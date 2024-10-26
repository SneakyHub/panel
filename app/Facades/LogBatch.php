<?php

namespace sneakypanel\Facades;

use Illuminate\Support\Facades\Facade;
use sneakypanel\Services\Activity\ActivityLogBatchService;

class LogBatch extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ActivityLogBatchService::class;
    }
}
