<?php

namespace Tests;

use MarketoClient\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function test_it_can_be_created()
    {
        $request = new Request();

        $this->assertNotNull($request);
        $this->assertEquals('GET', $request->method());
        $this->assertEquals('', $request->uri());
        $this->assertEquals([], $request->options());
    }

    public function test_add_query_value()
    {
        $request = new Request();

        $request->withQueryValue('foo', 'bar')
            ->withQueryValue('baz');

        $this->assertEquals([
            'query' => [
                'foo' => 'bar',
                'baz' => null,
            ],
        ], $request->options());
    }

    public function test_add_query()
    {
        $request = new Request();

        $request->withQuery([
            'foo' => 'bar',
            'baz' => null,
        ]);

        $this->assertEquals([
            'query' => [
                'foo' => 'bar',
                'baz' => null,
            ],
        ], $request->options());
    }

    public function test_without_query_value()
    {
        $request = (new Request())
            ->withQuery([
                'foo' => 'bar',
                'baz' => null,
            ])
            ->withoutQueryValue('foo');

        $this->assertEquals(['baz' => null], $request->query());
    }

    public function test_with_body()
    {
        $raw = json_encode(['foo' => 'bar']);

        $request = (new Request())
            ->withBody($raw);

        $this->assertEquals($raw, $request->body());
    }

    public function test_with_body_clears_other_body_types()
    {
        $json = ['foo' => 'bar'];

        $request = (new Request())
            ->withBody('baz')
            ->withJson($json);

        $this->assertEquals($json, $request->body());
    }

    public function test_without_body()
    {
        $request = (new Request())
            ->withBody('foo')
            ->withoutBody();

        $this->assertNull($request->body());
    }

    public function test_with_headers()
    {
        $request = (new Request())
            ->withHeaders(['Foo' => 'Bar']);

        $this->assertEquals(['Foo' => 'Bar'], $request->headers());
    }

    public function test_with_header()
    {
        $request = (new Request())
            ->withHeaders(['Foo' => 'Bar'])
            ->withHeader('Baz', 'Qux');
        $this->assertEquals(['Foo' => 'Bar', 'Baz' => 'Qux'], $request->headers());
        $this->assertEquals('Qux', $request->header('Baz'));
    }
}
