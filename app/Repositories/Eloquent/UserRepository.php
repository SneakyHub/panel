<?php

namespace sneakypanel\Repositories\Eloquent;

use sneakypanel\Models\User;
use sneakypanel\Contracts\Repository\UserRepositoryInterface;

class UserRepository extends EloquentRepository implements UserRepositoryInterface
{
    /**
     * Return the model backing this repository.
     */
    public function model(): string
    {
        return User::class;
    }
}
