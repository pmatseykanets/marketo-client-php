<?php

namespace Tests;

use MarketoClient\Resource;
use PHPUnit\Framework\TestCase;

class ResourceTest extends TestCase
{
    public function test_it_can_be_instantiated()
    {
        $client = new TestClient(['url' => 'https://foo.mktorest.com']);
        $resource = new TestResource($client);

        $this->assertInstanceOf(Resource::class, $resource);
    }
}

class TestResource extends Resource
{
    protected $uri = '/foo/bar';
}
