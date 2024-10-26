<?php

namespace sneakypanel\Http\Requests\Api\Client\Servers\Network;

use sneakypanel\Models\Permission;
use sneakypanel\Http\Requests\Api\Client\ClientApiRequest;

class DeleteAllocationRequest extends ClientApiRequest
{
    public function permission(): string
    {
        return Permission::ACTION_ALLOCATION_DELETE;
    }
}
