<?php

namespace MarketoClient\LeadDatabase\Lists;

use MarketoClient\Request;
use MarketoClient\Endpoint;

class FindList extends Endpoint
{
    protected $uri = '/rest/v1/lists';

    protected $required = ['id'];

    public function send()
    {
        $this->checkRequired();

        $request = Request::get($this->url("/$this->id.json"))
            ->withHeaders($this->client->baseHeaders());

        $response = $this->client->sendWithRetry($request);

        return $response;
    }

    public function id($value)
    {
        return $this->set(__FUNCTION__, $value);
    }
}
