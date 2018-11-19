<?php

namespace MarketoClient\LeadDatabase\CustomObjects;

use MarketoClient\Request;
use MarketoClient\Endpoint;

/**
 * Returns metadata regarding a given custom object.
 * @see http://developers.marketo.com/rest-api/endpoint-reference/lead-database-endpoint-reference/#!/Custom_Objects/describeUsingGET_1
 *
 * @property string $name
 */
class DescribeCustomObject extends Endpoint
{
    protected $uri = '/rest/v1/customobjects';

    public function send()
    {
        $request = Request::get($this->url("/$this->name/describe.json"))
            ->withHeaders($this->client->baseHeaders());

        $response = $this->client->sendWithRetry($request);

        return $response;
    }

    public function name($value)
    {
        return $this->set(__FUNCTION__, $value);
    }
}
