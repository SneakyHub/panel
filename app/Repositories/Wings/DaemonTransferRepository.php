<?php

namespace sneakypanel\Repositories\Wings;

use sneakypanel\Models\Node;
use Lcobucci\JWT\Token\Plain;
use GuzzleHttp\Exception\GuzzleException;
use sneakypanel\Exceptions\Http\Connection\DaemonConnectionException;

/**
 * @method \sneakypanel\Repositories\Wings\DaemonTransferRepository setNode(\sneakypanel\Models\Node $node)
 * @method \sneakypanel\Repositories\Wings\DaemonTransferRepository setServer(\sneakypanel\Models\Server $server)
 */
class DaemonTransferRepository extends DaemonRepository
{
    /**
     * @throws DaemonConnectionException
     */
    public function notify(Node $targetNode, Plain $token): void
    {
        try {
            $this->getHttpClient()->post(sprintf('/api/servers/%s/transfer', $this->server->uuid), [
                'json' => [
                    'server_id' => $this->server->uuid,
                    'url' => $targetNode->getConnectionAddress() . '/api/transfers',
                    'token' => 'Bearer ' . $token->toString(),
                    'server' => [
                        'uuid' => $this->server->uuid,
                        'start_on_completion' => false,
                    ],
                ],
            ]);
        } catch (GuzzleException $exception) {
            throw new DaemonConnectionException($exception);
        }
    }
}
