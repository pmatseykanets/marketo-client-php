<?php

namespace MarketoClient\LeadDatabase\Leads;

use MarketoClient\Request;
use MarketoClient\Endpoint;

/**
 * Syncs a list of leads to the target instance.
 * @see http://developers.marketo.com/rest-api/endpoint-reference/lead-database-endpoint-reference/#!/Leads/syncLeadUsingPOST
 *
 * @property string|null $action
 * @property bool|null $asyncProcessing
 * @property string|null $lookupField
 * @property string|null $partitionCode
 * @property string|null $partitionName
 * @property array $input
 */
class SyncLeads extends Endpoint
{
    protected $uri = '/rest/v1/leads';

    protected $required = ['input'];

    public function send()
    {
        $this->checkRequired();

        $request = Request::post($this->url('.json'))
            ->withHeaders($this->client->baseHeaders())
            ->withJson($this->query());

        $response = $this->client->sendWithRetry($request);

        return $response;
    }

    public function action($value)
    {
        return $this->set(__FUNCTION__, $value);
    }

    public function asyncProcessing($value)
    {
        return $this->set(__FUNCTION__, $value);
    }

    public function lookupField($value)
    {
        return $this->set(__FUNCTION__, $value);
    }

    public function partitionCode($value)
    {
        return $this->set(__FUNCTION__, $value);
    }

    public function partitionName($value)
    {
        return $this->set(__FUNCTION__, $value);
    }

    public function input($value)
    {
        return $this->set(__FUNCTION__, $value);
    }
}
