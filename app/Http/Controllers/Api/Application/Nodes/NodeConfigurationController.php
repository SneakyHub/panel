<?php

namespace sneakypanel\Http\Controllers\Api\Application\Nodes;

use sneakypanel\Models\Node;
use Illuminate\Http\JsonResponse;
use sneakypanel\Http\Requests\Api\Application\Nodes\GetNodeRequest;
use sneakypanel\Http\Controllers\Api\Application\ApplicationApiController;

class NodeConfigurationController extends ApplicationApiController
{
    /**
     * Returns the configuration information for a node. This allows for automated deployments
     * to remote machines so long as an API key is provided to the machine to make the request
     * with, and the node is known.
     */
    public function __invoke(GetNodeRequest $request, Node $node): JsonResponse
    {
        return new JsonResponse($node->getConfiguration());
    }
}
