<?php

namespace sneakypanel\Events\Server;

use sneakypanel\Events\Event;
use sneakypanel\Models\Server;
use Illuminate\Queue\SerializesModels;

class Deleted extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Server $server)
    {
    }
}
