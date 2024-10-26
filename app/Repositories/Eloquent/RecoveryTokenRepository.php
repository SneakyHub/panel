<?php

namespace sneakypanel\Repositories\Eloquent;

use sneakypanel\Models\RecoveryToken;

class RecoveryTokenRepository extends EloquentRepository
{
    public function model(): string
    {
        return RecoveryToken::class;
    }
}
