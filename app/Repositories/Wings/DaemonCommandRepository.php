<?php

namespace sneakypanel\Repositories\Wings;

use Webmozart\Assert\Assert;
use sneakypanel\Models\Server;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\TransferException;
use sneakypanel\Exceptions\Http\Connection\DaemonConnectionException;

/**
 * @method \sneakypanel\Repositories\Wings\DaemonCommandRepository setNode(\sneakypanel\Models\Node $node)
 * @method \sneakypanel\Repositories\Wings\DaemonCommandRepository setServer(\sneakypanel\Models\Server $server)
 */
class DaemonCommandRepository extends DaemonRepository
{
    /**
     * Sends a command or multiple commands to a running server instance.
     *
     * @throws DaemonConnectionException
     */
    public function send(array|string $command): ResponseInterface
    {
        Assert::isInstanceOf($this->server, Server::class);

        try {
            return $this->getHttpClient()->post(
                sprintf('/api/servers/%s/commands', $this->server->uuid),
                [
                    'json' => ['commands' => is_array($command) ? $command : [$command]],
                ]
            );
        } catch (TransferException $exception) {
            throw new DaemonConnectionException($exception);
        }
    }
}
