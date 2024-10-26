<?php

namespace sneakypanel\Exceptions\Service\Database;

use sneakypanel\Exceptions\DisplayException;

class TooManyDatabasesException extends DisplayException
{
    public function __construct()
    {
        parent::__construct('Operation aborted: creating a new database would put this server over the defined limit.');
    }
}
