<?php

namespace sneakypanel\Events\Auth;

use sneakypanel\Models\User;
use sneakypanel\Events\Event;

class DirectLogin extends Event
{
    public function __construct(public User $user, public bool $remember)
    {
    }
}
