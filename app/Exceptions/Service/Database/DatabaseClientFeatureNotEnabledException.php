<?php

namespace sneakypanel\Exceptions\Service\Database;

use sneakypanel\Exceptions\sneakypanelException;

class DatabaseClientFeatureNotEnabledException extends sneakypanelException
{
    public function __construct()
    {
        parent::__construct('Client database creation is not enabled in this Panel.');
    }
}
