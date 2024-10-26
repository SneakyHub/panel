<?php

namespace sneakypanel\Tests\Integration;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use sneakypanel\Tests\TestCase;
use Illuminate\Support\Facades\Event;
use sneakypanel\Events\ActivityLogged;
use sneakypanel\Tests\Assertions\AssertsActivityLogged;
use sneakypanel\Tests\Traits\Integration\CreatesTestModels;
use sneakypanel\Transformers\Api\Application\BaseTransformer;

abstract class IntegrationTestCase extends TestCase
{
    use CreatesTestModels;
    use AssertsActivityLogged;

    protected array $connectionsToTransact = ['mysql'];

    protected $defaultHeaders = [
        'Accept' => 'application/json',
    ];

    public function setUp(): void
    {
        parent::setUp();

        Event::fake(ActivityLogged::class);
    }

    /**
     * Return an ISO-8601 formatted timestamp to use in the API response.
     */
    protected function formatTimestamp(string $timestamp): string
    {
        return CarbonImmutable::createFromFormat(CarbonInterface::DEFAULT_TO_STRING_FORMAT, $timestamp)
            ->setTimezone(BaseTransformer::RESPONSE_TIMEZONE)
            ->toAtomString();
    }
}
