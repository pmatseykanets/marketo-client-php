<?php

namespace MarketoClient\LeadDatabase\CustomObjects;

use MarketoClient\Request;
use MarketoClient\Endpoint;

/**
 * Retrieves a list of custom objects records based on filter and set of values.
 * When action is createOnly, idField may not be used as a key and marketoGUID
 * cannot be a member of any object records.
 * @see http://developers.marketo.com/rest-api/endpoint-reference/lead-database-endpoint-reference/#!/Custom_Objects/getCustomObjectsUsingGET
 *
 * @property string $name
 * @property string $filterType
 * @property string|array $input
 * @property string|array|null $fields
 * @property int|null $batchSize
 * @property string|null $nextPageToken
 */
class GetCustomObjects extends Endpoint
{
    protected $uri = '/rest/v1/customobjects';

    protected $required = ['name', 'filterType', 'input'];

    protected $exclude = ['name'];

    public function send()
    {
        $this->checkRequired();

        do {
            $request = Request::post($this->url("/$this->name.json"))
                ->withHeaders($this->client->baseHeaders())
                ->withQueryValue('_method', 'GET')
                ->withJson($this->query());

            $response = $this->client->sendWithRetry($request);

            $this->nextPageToken($response->nextPageToken);

            yield $response;
        } while ($response->hasMorePages());
    }

    public function name($value)
    {
        return $this->set(__FUNCTION__, $value);
    }

    public function filterType($value)
    {
        return $this->set(__FUNCTION__, $value);
    }

    public function input($value)
    {
        return $this->set(__FUNCTION__, array_wrap($value));
    }

    public function fields($value)
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
