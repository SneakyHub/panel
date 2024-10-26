<?php

namespace sneakypanel\Http\Controllers\Api\Application\Users;

use sneakypanel\Models\User;
use sneakypanel\Transformers\Api\Application\UserTransformer;
use sneakypanel\Http\Controllers\Api\Application\ApplicationApiController;
use sneakypanel\Http\Requests\Api\Application\Users\GetExternalUserRequest;

class ExternalUserController extends ApplicationApiController
{
    /**
     * Retrieve a specific user from the database using their external ID.
     */
    public function index(GetExternalUserRequest $request, string $external_id): array
    {
        $user = User::query()->where('external_id', $external_id)->firstOrFail();

        return $this->fractal->item($user)
            ->transformWith($this->getTransformer(UserTransformer::class))
            ->toArray();
    }
}
