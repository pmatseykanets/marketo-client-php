<?php

namespace MarketoClient\LeadDatabase\Leads;

use MarketoClient\Request;
use MarketoClient\Endpoint;

/**
 * Upserts a lead, and generates a Push Lead to Marketo activity.
 * @see http://developers.marketo.com/rest-api/endpoint-reference/lead-database-endpoint-reference/#!/Leads/pushToMarketoUsingPOST
 *
 * @property string|null $lookupField
 * @property string|null $partitionName
 * @property string|null $programName
 * @property string|null $programStatus
 * @property string|null $reason
 * @property string|null $source
 * @property array $input
 */
class PushLeads extends Endpoint
{
    protected $uri = '/rest/v1/leads';

    protected $required = ['input'];

    public function send()
    {
        $this->checkRequired();

        $request = Request::post($this->url('/push.json'))
            ->withHeaders($this->client->baseHeaders())
            ->withJson($this->query());

        $response = $this->client->sendWithRetry($request);

        return $response;
    }

    public function lookupField($value)
    {
        return $this->set(__FUNCTION__, $value);
    }

    public function partitionName($value)
    {
        return $this->set(__FUNCTION__, $value);
    }

    public function programName($value)
    {
        return $this->set(__FUNCTION__, $value);
    }

    public function programStatus($value)
    {
        return $this->set(__FUNCTION__, $value);
    }

    public function reason($value)
    {
        return $this->set(__FUNCTION__, $value);
    }

    public function source($value)
    {
        return $this->set(__FUNCTION__, $value);
    }

    public function input($value)
    {
        return $this->set(__FUNCTION__, $value);
    }
}
