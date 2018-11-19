<?php

namespace MarketoClient\LeadDatabase\CustomObjects;

use MarketoClient\Request;
use MarketoClient\Endpoint;

/**
 * Returns a list of Custom Object types available in the target instance,
 * along with id and deduplication information for each type.
 * @see http://developers.marketo.com/rest-api/endpoint-reference/lead-database-endpoint-reference/#!/Custom_Objects/listCustomObjectsUsingGET
 *
 * @property string|array|null $names
 * @property string|null $nextPageToken
 */
class GetCustomObjectTypes extends Endpoint
{
    protected $uri = '/rest/v1/customobjects';

    protected $listable = ['names'];

    public function send()
    {
        do {
            $request = Request::post($this->url('.json'))
                ->withHeaders($this->client->baseHeaders())
                ->withQueryValue('_method', 'GET')
                ->withFormParams($this->query());

            $response = $this->client->sendWithRetry($request);

            $this->nextPageToken($response->nextPageToken);

            yield $response;
        } while ($response->hasMorePages());
    }

    public function names($value)
    {
        return $this->set(__FUNCTION__, is_array($value) ? $value : func_get_args());
    }

    public function nextPageToken($value)
    {
        return $this->set(__FUNCTION__, $value);
    }
}
