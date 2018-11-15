<?php

namespace Tests\LeadDatabase\Activities;

use DateTime;
use MarketoClient\LeadDatabase\Activities\GetPagingToken;
use PHPUnit\Framework\TestCase;
use Tests\TestClient;

class PagingTokenTest extends TestCase
{
    public function test_since()
    {
        $endpoint = new GetPagingToken(new TestClient());

        $endpoint->sinceDateTime('yesterday');
        $this->assertEquals(new DateTime('yesterday'), $endpoint->sinceDateTime);

        $now = new DateTime();
        $endpoint->sinceDateTime($now);
        $this->assertEquals($now, $endpoint->sinceDateTime);
    }
}
