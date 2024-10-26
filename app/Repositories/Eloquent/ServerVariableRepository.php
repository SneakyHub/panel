<?php

namespace sneakypanel\Repositories\Eloquent;

use sneakypanel\Models\ServerVariable;
use sneakypanel\Contracts\Repository\ServerVariableRepositoryInterface;

class ServerVariableRepository extends EloquentRepository implements ServerVariableRepositoryInterface
{
    /**
     * Return the model backing this repository.
     */
    public function model(): string
    {
        return ServerVariable::class;
    }
}
