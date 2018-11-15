<?php

namespace MarketoClient\LeadDatabase\Leads;

use MarketoClient\Request;
use MarketoClient\Endpoint;

/**
 * Returns metadata about lead objects in the target instance, including a list of all fields available for interaction via the APIs.
 * @see http://developers.marketo.com/rest-api/endpoint-reference/lead-database-endpoint-reference/#!/Leads/describeUsingGET_2
 */
class DescribeLead extends Endpoint
{
    protected $uri = '/rest/v1/leads';

    public function send()
    {
        $request = Request::get($this->url('/describe.json'))
            ->withHeaders($this->client->baseHeaders());

        $response = $this->client->sendWithRetry($request);

        return $response;
    }
}
