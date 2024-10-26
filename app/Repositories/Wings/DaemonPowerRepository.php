<?php

namespace sneakypanel\Repositories\Wings;

use Webmozart\Assert\Assert;
use sneakypanel\Models\Server;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\TransferException;
use sneakypanel\Exceptions\Http\Connection\DaemonConnectionException;

/**
 * @method \sneakypanel\Repositories\Wings\DaemonPowerRepository setNode(\sneakypanel\Models\Node $node)
 * @method \sneakypanel\Repositories\Wings\DaemonPowerRepository setServer(\sneakypanel\Models\Server $server)
 */
class DaemonPowerRepository extends DaemonRepository
{
    /**
     * Sends a power action to the server instance.
     *
     * @throws DaemonConnectionException
     */
    public function send(string $action): ResponseInterface
    {
        Assert::isInstanceOf($this->server, Server::class);

        try {
            return $this->getHttpClient()->post(
                sprintf('/api/servers/%s/power', $this->server->uuid),
                ['json' => ['action' => $action]]
            );
        } catch (TransferException $exception) {
            throw new DaemonConnectionException($exception);
        }
    }
}
