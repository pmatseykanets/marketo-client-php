<?php

namespace Tests;

use DateInterval;
use DateTime;
use MarketoClient\AccessToken;
use PHPUnit\Framework\TestCase;

class AccessTokenTest extends TestCase
{
    public function test_it_can_be_created()
    {
        $token = new AccessToken('foo', 60, 'client_credentials', 'bar');

        $this->assertEquals('foo', $token->accessToken);
        $this->assertEquals(60, $token->expiresIn);
        $this->assertEquals('client_credentials', $token->type);
        $this->assertEquals('bar', $token->scope);

        $this->assertFalse($token->isExpired());
    }

    public function test_it_reports_is_expired()
    {
        $timestamp = (new DateTime())->sub(new DateInterval('PT120S'));

        $token = new AccessToken('foo', 60, 'client_credentials', 'bar', $timestamp);

        $this->assertTrue($token->isExpired());
    }

    public function test_it_casts_to_string()
    {
        $token = new AccessToken('foo', 60, 'client_credentials', 'bar');

        $this->assertEquals('foo', (string) $token);
    }

    public function test_to_array()
    {
        $token = new AccessToken('foo', 60, 'client_credentials', 'bar');

        $this->assertEquals([
            'access_token' => 'foo',
            'expires_in' => 60,
            'type' => 'client_credentials',
            'scope' => 'bar',
        ], $token->toArray());
    }
}
