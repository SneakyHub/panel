<?php

namespace sneakypanel\Http\Controllers\Api\Application\Servers;

use sneakypanel\Models\User;
use sneakypanel\Models\Server;
use sneakypanel\Services\Servers\StartupModificationService;
use sneakypanel\Transformers\Api\Application\ServerTransformer;
use sneakypanel\Http\Controllers\Api\Application\ApplicationApiController;
use sneakypanel\Http\Requests\Api\Application\Servers\UpdateServerStartupRequest;

class StartupController extends ApplicationApiController
{
    /**
     * StartupController constructor.
     */
    public function __construct(private StartupModificationService $modificationService)
    {
        parent::__construct();
    }

    /**
     * Update the startup and environment settings for a specific server.
     *
     * @throws \Illuminate\Validation\ValidationException
     * @throws \sneakypanel\Exceptions\Http\Connection\DaemonConnectionException
     * @throws \sneakypanel\Exceptions\Model\DataValidationException
     * @throws \sneakypanel\Exceptions\Repository\RecordNotFoundException
     */
    public function index(UpdateServerStartupRequest $request, Server $server): array
    {
        $server = $this->modificationService
            ->setUserLevel(User::USER_LEVEL_ADMIN)
            ->handle($server, $request->validated());

        return $this->fractal->item($server)
            ->transformWith($this->getTransformer(ServerTransformer::class))
            ->toArray();
    }
}
