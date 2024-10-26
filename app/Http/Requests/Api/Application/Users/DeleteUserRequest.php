<?php

namespace sneakypanel\Http\Requests\Api\Application\Users;

use sneakypanel\Services\Acl\Api\AdminAcl;
use sneakypanel\Http\Requests\Api\Application\ApplicationApiRequest;

class DeleteUserRequest extends ApplicationApiRequest
{
    protected ?string $resource = AdminAcl::RESOURCE_USERS;

    protected int $permission = AdminAcl::WRITE;
}
