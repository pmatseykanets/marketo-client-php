<?php

namespace MarketoClient\LeadDatabase\CustomObjects;

use MarketoClient\Request;
use MarketoClient\Endpoint;

/**
 * Deletes a given set of custom object records.
 * @see http://developers.marketo.com/rest-api/endpoint-reference/lead-database-endpoint-reference/#!/Custom_Objects/deleteCustomObjectsUsingPOST
 *
 * @property string $name
 * @property string $deleteBy
 * @property string|array $input
 */
class DeleteCustomObjects extends Endpoint
{
    protected $uri = '/rest/v1/customobjects';

    protected $required = ['name', 'input'];

    protected $exclude = ['name'];

    public function send()
    {
        $this->checkRequired();

        $request = Request::post($this->url("/$this->name/delete.json"))
            ->withHeaders($this->client->baseHeaders())
            ->withJson($this->query());

        $response = $this->client->sendWithRetry($request);

        return $response;
    }

    public function deleteBy($value)
    {
        return $this->set(__FUNCTION__, $value);
    }

    public function input($value)
    {
        return $this->set(__FUNCTION__, array_wrap($value));
    }
}
