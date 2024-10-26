<?php

namespace sneakypanel\Http\Requests\Api\Application\Users;

use sneakypanel\Services\Acl\Api\AdminAcl as Acl;
use sneakypanel\Http\Requests\Api\Application\ApplicationApiRequest;

class GetUsersRequest extends ApplicationApiRequest
{
    protected ?string $resource = Acl::RESOURCE_USERS;

    protected int $permission = Acl::READ;
}
