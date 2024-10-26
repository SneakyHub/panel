<?php

namespace sneakypanel\Http\Requests\Api\Client\Servers\Databases;

use sneakypanel\Models\Permission;
use sneakypanel\Http\Requests\Api\Client\ClientApiRequest;

class RotatePasswordRequest extends ClientApiRequest
{
    /**
     * Check that the user has permission to rotate the password.
     */
    public function permission(): string
    {
        return Permission::ACTION_DATABASE_UPDATE;
    }
}
