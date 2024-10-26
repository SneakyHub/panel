<?php

namespace sneakypanel\Http\Requests\Api\Application\Allocations;

use sneakypanel\Services\Acl\Api\AdminAcl;
use sneakypanel\Http\Requests\Api\Application\ApplicationApiRequest;

class DeleteAllocationRequest extends ApplicationApiRequest
{
    protected ?string $resource = AdminAcl::RESOURCE_ALLOCATIONS;

    protected int $permission = AdminAcl::WRITE;
}
