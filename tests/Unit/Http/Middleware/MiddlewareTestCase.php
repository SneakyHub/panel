<?php

namespace sneakypanel\Tests\Unit\Http\Middleware;

use sneakypanel\Tests\TestCase;
use sneakypanel\Tests\Traits\Http\RequestMockHelpers;
use sneakypanel\Tests\Traits\Http\MocksMiddlewareClosure;
use sneakypanel\Tests\Assertions\MiddlewareAttributeAssertionsTrait;

abstract class MiddlewareTestCase extends TestCase
{
    use MiddlewareAttributeAssertionsTrait;
    use MocksMiddlewareClosure;
    use RequestMockHelpers;

    /**
     * Setup tests with a mocked request object and normal attributes.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->buildRequestMock();
    }
}
