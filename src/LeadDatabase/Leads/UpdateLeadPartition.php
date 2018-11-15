<?php

namespace MarketoClient\LeadDatabase\Leads;

use MarketoClient\Endpoint;
use MarketoClient\Request;

/**
 * Updates the lead partition for a list of leads.
 * @see http://developers.marketo.com/rest-api/endpoint-reference/lead-database-endpoint-reference/#!/Leads/updatePartitionsUsingPOST
 *
 * @property array $input
 */
class UpdateLeadPartition extends Endpoint
{
    protected $uri = '/rest/v1/leads';

    protected $required = ['input'];

    public function send()
    {
        $this->checkRequired();

        $request = Request::post($this->url('partitions.json'))
            ->withHeaders($this->client->baseHeaders())
            ->withQueryValue('_method', 'GET')
            ->withFormParams($this->query());

        $response = $this->client->sendWithRetry($request);

        return $response;
    }

    public function input($value)
    {
        return $this->set(__FUNCTION__, $value);
    }
}
