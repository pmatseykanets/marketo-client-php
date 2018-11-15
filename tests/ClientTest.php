<?php

namespace Tests;

use MarketoClient\Client;
use MarketoClient\Request;
use GuzzleHttp\Psr7\Response;
use MarketoClient\MemoryStore;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;

class ClientTest extends TestCase
{
    public function test_it_can_be_instantiated()
    {
        $client = new TestClient([]);

        $this->assertInstanceOf(Client::class, $client);
    }

    public function test_it_reads_config_values_from_env()
    {
        $id = '02d92ff0-9d94-4de7-b152-3df68969b947';
        $secret = 'bB6wmEvjlsfVr1Vs3NfGwSD9HL2AAHzZ';
        $url = 'https://123-XYZ-456.mktorest.com';

        putenv("MARKETO_CLIENT_ID=$id");
        putenv("MARKETO_CLIENT_SECRET=$secret");
        putenv("MARKETO_URL=$url");

        $client = new TestClient();

        $this->assertEquals($id, $client->config(Client::CONFIG_CLIENT_ID));
        $this->assertEquals($secret, $client->config(Client::CONFIG_CLIENT_SECRET));
        $this->assertEquals($url, $client->config(Client::CONFIG_URL));
    }

    public function test_passed_config_values_takes_precedence_over_env()
    {
        putenv('MARKETO_CLIENT_ID=foo');
        putenv('MARKETO_CLIENT_SECRET=bar');
        putenv('MARKETO_URL=baz');

        $id = '02d92ff0-9d94-4de7-b152-3df68969b947';
        $secret = 'bB6wmEvjlsfVr1Vs3NfGwSD9HL2AAHzZ';
        $url = 'https://123-XYZ-456.mktorest.com';

        $client = new TestClient([
            Client::CONFIG_CLIENT_ID => $id,
            Client::CONFIG_CLIENT_SECRET => $secret,
            Client::CONFIG_URL => $url,
        ]);

        $this->assertEquals($id, $client->config(Client::CONFIG_CLIENT_ID));
        $this->assertEquals($secret, $client->config(Client::CONFIG_CLIENT_SECRET));
        $this->assertEquals($url, $client->config(Client::CONFIG_URL));
    }

    public function test_reads_missing_config_values_from_env()
    {
        $id = '02d92ff0-9d94-4de7-b152-3df68969b947';
        $secret = 'bB6wmEvjlsfVr1Vs3NfGwSD9HL2AAHzZ';
        $url = 'https://123-XYZ-456.mktorest.com';

        putenv("MARKETO_URL=$url");

        $client = new TestClient([
            Client::CONFIG_CLIENT_ID => $id,
            Client::CONFIG_CLIENT_SECRET => $secret,
        ]);

        $this->assertEquals($id, $client->config(Client::CONFIG_CLIENT_ID));
        $this->assertEquals($secret, $client->config(Client::CONFIG_CLIENT_SECRET));
        $this->assertEquals($url, $client->config(Client::CONFIG_URL));
    }

    public function test_url()
    {
        $client = new TestClient(['url' => 'https://foo.mktorest.com']);

        $this->assertEquals('https://foo.mktorest.com/rest/v1/foo.json', $client->url('/rest/v1/foo.json'));
    }

    public function test_base_headers_has_authorization()
    {
        $token = base64_encode(md5(rand(1, 1000)));

        $client = new TestClient();
        $client->accessToken = $token;

        $this->assertEquals("Bearer $token", $client->baseHeaders()['Authorization']);
    }

    public function test_base_headers_has_accept_encoding_gzip()
    {
        $client = new TestClient();

        $this->assertEquals("gzip", $client->baseHeaders()['Accept-Encoding']);
    }

    public function test_it_creates_memory_store_by_default()
    {
        $client = new TestClient();

        $this->assertInstanceOf(MemoryStore::class, $client->store());
    }

    public function test_it_creates_guzzle_http_client_by_default()
    {
        $client = new TestClient();

        $this->assertInstanceOf(\GuzzleHttp\Client::class, $client->http());
    }

    public function test_send()
    {
        $http = new TestHttpClient();
        $client = new TestClient([], $http);
        $request = Request::get('/foo/bar', ['baz' => 'qux']);

        $client->send($request);

        $this->assertEquals(1, count($http->requests));
        $this->assertEquals('GET', $http->requests[0]['method']);
        $this->assertEquals('/foo/bar', $http->requests[0]['uri']);
        $this->assertEquals(['baz' => 'qux'], $http->requests[0]['options']);
    }
}

class TestClient extends Client
{
    public $accessToken = '';

    public function accessToken()
    {
        return $this->accessToken;
    }
}

class TestHttpClient implements ClientInterface
{
    public $requests = [];

    public $expectedResponse;

    public function send(RequestInterface $request, array $options = [])
    {
        throw new \Exception('Not Implemented');
    }

    public function sendAsync(RequestInterface $request, array $options = [])
    {
        throw new \Exception('Not Implemented');
    }

    public function request($method, $uri, array $options = [])
    {
        $this->requests[] = compact('method', 'uri', 'options');

        return $this->expectedResponse ?: new Response();
    }

    public function requestAsync($method, $uri, array $options = [])
    {
        throw new \Exception('Not Implemented');
    }

    public function getConfig($option = null)
    {
        throw new \Exception('Not Implemented');
    }
}
