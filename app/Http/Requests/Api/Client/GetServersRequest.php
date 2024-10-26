<?php

namespace sneakypanel\Http\Requests\Api\Client;

class GetServersRequest extends ClientApiRequest
{
    public function authorize(): bool
    {
        return true;
    }
}
