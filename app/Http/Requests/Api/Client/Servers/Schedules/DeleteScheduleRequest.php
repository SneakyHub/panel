<?php

namespace sneakypanel\Http\Requests\Api\Client\Servers\Schedules;

use sneakypanel\Models\Permission;

class DeleteScheduleRequest extends ViewScheduleRequest
{
    public function permission(): string
    {
        return Permission::ACTION_SCHEDULE_DELETE;
    }
}
