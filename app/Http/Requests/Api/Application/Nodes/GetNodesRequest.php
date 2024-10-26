<?php

namespace sneakypanel\Http\Requests\Api\Application\Nodes;

use sneakypanel\Services\Acl\Api\AdminAcl;
use sneakypanel\Http\Requests\Api\Application\ApplicationApiRequest;

class GetNodesRequest extends ApplicationApiRequest
{
    protected ?string $resource = AdminAcl::RESOURCE_NODES;

    protected int $permission = AdminAcl::READ;
}
