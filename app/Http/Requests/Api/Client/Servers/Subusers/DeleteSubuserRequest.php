<?php

namespace sneakypanel\Http\Requests\Api\Client\Servers\Subusers;

use sneakypanel\Models\Permission;

class DeleteSubuserRequest extends SubuserRequest
{
    public function permission(): string
    {
        return Permission::ACTION_USER_DELETE;
    }
}
