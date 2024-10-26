<?php

namespace sneakypanel\Exceptions\Service;

use Illuminate\Http\Response;
use sneakypanel\Exceptions\DisplayException;

class HasActiveServersException extends DisplayException
{
    public function getStatusCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }
}
