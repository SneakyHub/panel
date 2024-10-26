<?php

namespace sneakypanel\Events\Subuser;

use sneakypanel\Events\Event;
use sneakypanel\Models\Subuser;
use Illuminate\Queue\SerializesModels;

class Deleted extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Subuser $subuser)
    {
    }
}
