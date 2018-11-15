<?php

namespace MarketoClient\LeadDatabase\Leads;

use MarketoClient\Request;
use MarketoClient\Endpoint;

/**
 * Returns a list of available partitions in the target instance.
 * @see http://developers.marketo.com/rest-api/endpoint-reference/lead-database-endpoint-reference/#!/Leads/getLeadPartitionsUsingGET
 *
 * @property string|null $nextPageToken
 */
class GetLeadPartitions extends Endpoint
{
    protected $uri = '/rest/v1/leads';

    public function send()
    {
        do {
            $request = Request::get($this->url('/partitions.json'))
                ->withHeaders($this->client->baseHeaders())
                ->withQuery($this->query());

            $response = $this->client->sendWithRetry($request);

            $this->nextPageToken($response->nextPageToken);

            yield $response;
        } while (isset($response->nextPageToken));
    }

    public function nextPageToken($value)
    {
        return $this->set(__FUNCTION__, $value);
    }
}
