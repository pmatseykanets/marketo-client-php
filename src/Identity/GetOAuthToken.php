<?php

namespace MarketoClient\Identity;

use MarketoClient\Client;
use MarketoClient\Request;
use MarketoClient\Endpoint;

/**
 * Retrieve an access token from Marketo.
 * @see http://developers.marketo.com/rest-api/endpoint-reference/authentication-endpoint-reference/#!/Identity/identityUsingGET
 */
class GetOAuthToken extends Endpoint
{
    protected $uri = '/identity/oauth/token';

    public function send()
    {
        $request = Request::get($this->url())
            ->withHeader('Accept', 'application/json')
            ->withQuery($this->query());

        $response = $this->client->sendWithRetry($request);

        return $response;
    }

    public function query()
    {
        $query = [
            'grant_type' => 'client_credentials',
            'client_id' => $this->client->config(Client::CONFIG_CLIENT_ID),
            'client_secret' => $this->client->config(Client::CONFIG_CLIENT_SECRET),
        ];

        if ($partnerId = $this->client->config(Client::CONFIG_PARTNER_ID)) {
            $query[Client::CONFIG_PARTNER_ID] = $partnerId;
        }

        return $query;
    }
}
