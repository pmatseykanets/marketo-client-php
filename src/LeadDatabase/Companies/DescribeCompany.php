<?php

namespace MarketoClient\LeadDatabase\Companies;

use MarketoClient\Request;
use MarketoClient\Endpoint;

/**
 * Returns metadata about companies and the fields available for interaction via the API.
 * @see http://developers.marketo.com/rest-api/endpoint-reference/lead-database-endpoint-reference/#!/Companies/describeUsingGET
 */
class DescribeCompany extends Endpoint
{
    protected $uri = '/rest/v1/companies';

    public function send()
    {
        $request = Request::get($this->url('/describe.json'))
            ->withHeaders($this->client->baseHeaders());

        $response = $this->client->sendWithRetry($request);

        return $response;
    }
}
