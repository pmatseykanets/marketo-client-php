<?php

namespace Tests;

use MarketoClient\MemoryStore;
use PHPUnit\Framework\TestCase;

class MemoryStoreTest extends TestCase
{
    public function test_it_can_be_created()
    {
        $store = new MemoryStore();

        $this->assertNotNull($store);
    }

    public function test_increment()
    {
        $store = new MemoryStore();

        $this->assertEquals(1, $store->increment('foo'));
        $this->assertEquals(2, $store->increment('foo'));
    }

    public function test_put_get()
    {
        $store = new MemoryStore();

        $store->put('foo', 'bar');
        $this->assertEquals('bar', $store->get('foo'));
    }

    public function test_has()
    {
        $store = new MemoryStore();

        $store->put('foo');
        $this->assertTrue($store->has('foo'));
        $this->assertFalse($store->has('bar'));
    }
}
