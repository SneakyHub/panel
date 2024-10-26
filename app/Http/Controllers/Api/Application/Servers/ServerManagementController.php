<?php

namespace sneakypanel\Http\Controllers\Api\Application\Servers;

use Illuminate\Http\Response;
use sneakypanel\Models\Server;
use sneakypanel\Services\Servers\SuspensionService;
use sneakypanel\Services\Servers\ReinstallServerService;
use sneakypanel\Http\Requests\Api\Application\Servers\ServerWriteRequest;
use sneakypanel\Http\Controllers\Api\Application\ApplicationApiController;

class ServerManagementController extends ApplicationApiController
{
    /**
     * ServerManagementController constructor.
     */
    public function __construct(
        private ReinstallServerService $reinstallServerService,
        private SuspensionService $suspensionService,
    ) {
        parent::__construct();
    }

    /**
     * Suspend a server on the Panel.
     *
     * @throws \Throwable
     */
    public function suspend(ServerWriteRequest $request, Server $server): Response
    {
        $this->suspensionService->toggle($server);

        return $this->returnNoContent();
    }

    /**
     * Unsuspend a server on the Panel.
     *
     * @throws \Throwable
     */
    public function unsuspend(ServerWriteRequest $request, Server $server): Response
    {
        $this->suspensionService->toggle($server, SuspensionService::ACTION_UNSUSPEND);

        return $this->returnNoContent();
    }

    /**
     * Mark a server as needing to be reinstalled.
     *
     * @throws \sneakypanel\Exceptions\DisplayException
     * @throws \sneakypanel\Exceptions\Model\DataValidationException
     * @throws \sneakypanel\Exceptions\Repository\RecordNotFoundException
     */
    public function reinstall(ServerWriteRequest $request, Server $server): Response
    {
        $this->reinstallServerService->handle($server);

        return $this->returnNoContent();
    }
}
