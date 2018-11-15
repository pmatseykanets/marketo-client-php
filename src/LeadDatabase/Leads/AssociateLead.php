<?php

namespace MarketoClient\LeadDatabase\Leads;

use MarketoClient\Request;
use MarketoClient\Endpoint;

/**
 * Associates a known Marketo lead record to a munchkin cookie and its associated web acitvity history.
 * @see http://developers.marketo.com/rest-api/endpoint-reference/lead-database-endpoint-reference/#!/Leads/associateLeadUsingPOST
 *
 * @property int $leadId
 * @property string $cookie
 */
class AssociateLead extends Endpoint
{
    protected $uri = '/rest/v1/leads';

    protected $required = ['leadId', 'cookie'];

    public function send()
    {
        $this->checkRequired();

        $request = Request::post($this->url("/$this->leadId/associate.json"))
            ->withHeaders($this->client->baseHeaders())
            ->withQueryValue('cookie', $this->cookie);

        $response = $this->client->sendWithRetry($request);

        return $response;
    }

    public function cookie($value)
    {
        return $this->set(__FUNCTION__, $value);
    }
}
