<?php

namespace sneakypanel\Http\Requests\Api\Application\Servers;

use sneakypanel\Services\Acl\Api\AdminAcl;
use sneakypanel\Http\Requests\Api\Application\ApplicationApiRequest;

class ServerWriteRequest extends ApplicationApiRequest
{
    protected ?string $resource = AdminAcl::RESOURCE_SERVERS;

    protected int $permission = AdminAcl::WRITE;
}
