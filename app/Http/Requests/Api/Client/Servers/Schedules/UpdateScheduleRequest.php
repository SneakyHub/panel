<?php

namespace sneakypanel\Http\Requests\Api\Client\Servers\Schedules;

use sneakypanel\Models\Permission;

class UpdateScheduleRequest extends StoreScheduleRequest
{
    public function permission(): string
    {
        return Permission::ACTION_SCHEDULE_UPDATE;
    }
}
