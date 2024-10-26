<?php

namespace sneakypanel\Http\Requests\Api\Client\Servers\Databases;

use sneakypanel\Models\Permission;
use sneakypanel\Contracts\Http\ClientPermissionsRequest;
use sneakypanel\Http\Requests\Api\Client\ClientApiRequest;

class DeleteDatabaseRequest extends ClientApiRequest implements ClientPermissionsRequest
{
    public function permission(): string
    {
        return Permission::ACTION_DATABASE_DELETE;
    }
}
