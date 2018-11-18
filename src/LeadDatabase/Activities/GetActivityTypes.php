<?php

namespace MarketoClient\LeadDatabase\Activities;

use MarketoClient\Request;
use MarketoClient\Endpoint;

/**
 * Returns a list of available activity types in the target instance,
 * along with associated metadata of each type.
 * @see http://developers.marketo.com/rest-api/endpoint-reference/lead-database-endpoint-reference/#!/Activities/getAllActivityTypesUsingGET
 *
 * @property string|null $nextPageToken
 */
class GetActivityTypes extends Endpoint
{
    protected $uri = '/rest/v1/activities';

    protected $required = [];

    public function send()
    {
        do {
            $request = Request::get($this->url('/types.json'))
                ->withHeaders($this->client->baseHeaders())
                ->withQuery($this->query());

            $response = $this->client->sendWithRetry($request);

            $this->nextPageToken($response->nextPageToken);

            yield $response;
        } while ($response->hasMorePages());
    }

    public function nextPageToken($value)
    {
        return $this->set(__FUNCTION__, $value);
    }
}
