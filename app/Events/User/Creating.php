<?php

namespace sneakypanel\Events\User;

use sneakypanel\Models\User;
use sneakypanel\Events\Event;
use Illuminate\Queue\SerializesModels;

class Creating extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public User $user)
    {
    }
}
