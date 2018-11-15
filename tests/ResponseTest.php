<?php

namespace Tests;

use Mockery;
use MarketoClient\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ResponseTest extends TestCase
{
    public function test_it_can_be_instantiated()
    {
        $psr = Mockery::mock(ResponseInterface::class);
        $response = new Response($psr);

        $this->assertInstanceOf(Response::class, $response);
    }

    public function test_raw_body()
    {
        $psr = Mockery::mock(ResponseInterface::class);
        $psr->shouldReceive('getBody')
            ->once()
            ->andReturn(Mockery::mock(StreamInterface::class));

        $response = new Response($psr);

        $this->assertInstanceOf(StreamInterface::class, $response->rawBody());
    }

    public function test_body()
    {
        $psr = Mockery::mock(ResponseInterface::class);
        $psr->shouldReceive('getBody')
            ->once()
            ->andReturn('{"requestId": 123, "success": true, "result": []}');

        $response = new Response($psr);

        $expected = new \stdClass();
        $expected->requestId = 123;
        $expected->success = true;
        $expected->result = [];

        $this->assertEquals($expected, $response->body());
    }

    public function test_accessors()
    {
        $psr = Mockery::mock(ResponseInterface::class);
        $psr->shouldReceive('getBody')
            ->once()
            ->andReturn('{"requestId": 123, "success": true, "result": []}');

        $response = new Response($psr);

        $this->assertTrue($response->success);
        $this->assertEquals(123, $response->requestId);
        $this->assertEquals([], $response->result);
    }
}
