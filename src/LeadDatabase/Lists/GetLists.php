<?php

namespace MarketoClient\LeadDatabase\Lists;

use MarketoClient\Request;
use MarketoClient\Endpoint;

/**
 * Returns a set of static list records based on given filter parameters.
 * @see http://developers.marketo.com/rest-api/endpoint-reference/lead-database-endpoint-reference/#!/Static_Lists/getListsUsingGET
 *
 * @property int|array|string|null $id
 * @property array|string|null $name
 * @property array|string|null $programName
 * @property array|string|null $workspaceName
 * @property int|null $batchSize
 * @property string|null $nextPageToken
 */
class GetLists extends Endpoint
{
    protected $uri = '/rest/v1/lists';

    protected $listable = ['id', 'name', 'programName', 'workspaceName'];

    public function send()
    {
        $this->checkRequired();

        do {
            $request = Request::post($this->url('.json'))
                ->withHeaders($this->client->baseHeaders())
                ->withQueryValue('_method', 'GET')
                ->withFormParams($this->query());

            $response = $this->client->sendWithRetry($request);

            $this->nextPageToken($response->nextPageToken);

            yield $response;
        } while (isset($response->nextPageToken));
    }

    public function id($value)
    {
        return $this->set(__FUNCTION__, is_array($value) ? $value : func_get_args());
    }

    public function name($value)
    {
        return $this->set(__FUNCTION__, is_array($value) ? $value : func_get_args());
    }

    public function programName($value)
    {
        return $this->set(__FUNCTION__, is_array($value) ? $value : func_get_args());
    }

    public function workspaceName($value)
    {
        return $this->set(__FUNCTION__, is_array($value) ? $value : func_get_args());
    }

    public function batchSize($value)
    {
        return $this->set(__FUNCTION__, $value);
    }

    public function nextPageToken($value)
    {
        return $this->set(__FUNCTION__, $value);
    }
}
