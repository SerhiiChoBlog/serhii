<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Middleware;

use Tests\TestCase;

class TrustProxiesTest extends TestCase
{
    public function testClientIpIsTakenFromForwardedHeaderWhenRequestComesFromTrustedProxy(): void
    {
        $this->withServerVariables(['REMOTE_ADDR' => '10.89.8.3'])
            ->withHeaders(['X-Forwarded-For' => '203.0.113.7'])
            ->get('/up');

        $this->assertSame('203.0.113.7', $this->app['request']->ip());
    }

    public function testForwardedHeaderIsIgnoredWhenRequestComesFromUntrustedProxy(): void
    {
        $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.9'])
            ->withHeaders(['X-Forwarded-For' => '1.2.3.4'])
            ->get('/up');

        $this->assertSame('203.0.113.9', $this->app['request']->ip());
    }
}
