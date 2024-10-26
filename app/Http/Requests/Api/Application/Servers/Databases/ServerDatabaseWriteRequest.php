<?php

namespace sneakypanel\Http\Requests\Api\Application\Servers\Databases;

use sneakypanel\Services\Acl\Api\AdminAcl;

class ServerDatabaseWriteRequest extends GetServerDatabasesRequest
{
    protected int $permission = AdminAcl::WRITE;
}
