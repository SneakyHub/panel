<?php

namespace sneakypanel\Http\Requests\Api\Client\Servers\Backups;

use sneakypanel\Models\Permission;
use sneakypanel\Http\Requests\Api\Client\ClientApiRequest;

class RestoreBackupRequest extends ClientApiRequest
{
    public function permission(): string
    {
        return Permission::ACTION_BACKUP_RESTORE;
    }

    public function rules(): array
    {
        return ['truncate' => 'required|boolean'];
    }
}
