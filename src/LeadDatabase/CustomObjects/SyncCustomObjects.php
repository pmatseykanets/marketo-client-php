<?php

namespace MarketoClient\LeadDatabase\CustomObjects;

use MarketoClient\Request;
use MarketoClient\Endpoint;

/**
 * Inserts, updates, or upserts custom object records to the target instance.
 * @see http://developers.marketo.com/rest-api/endpoint-reference/lead-database-endpoint-reference/#!/Custom_Objects/syncCustomObjectsUsingPOST
 *
 * @property string $name
 * @property string|null $action createOnly, updateOnly, createOrUpdate
 * @property string|null $dedupeBy
 * @property string|array $input
 */
class SyncCustomObjects extends Endpoint
{
    protected $uri = '/rest/v1/customobjects';

    protected $required = ['name', 'input'];

    protected $exclude = ['name'];

    public function send()
    {
        $this->checkRequired();

        $request = Request::post($this->url("/$this->name.json"))
            ->withHeaders($this->client->baseHeaders())
            ->withJson($this->query());

        $response = $this->client->sendWithRetry($request);

        return $response;
    }

    public function name($value)
    {
        return $this->set(__FUNCTION__, $value);
    }

    public function action($value)
    {
        return $this->set(__FUNCTION__, $value);
    }

    public function dedupeBy($value)
    {
        return $this->set(__FUNCTION__, $value);
    }

    public function input($value)
    {
        return $this->set(__FUNCTION__, array_wrap($value));
    }
}
