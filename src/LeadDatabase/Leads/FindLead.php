<?php

namespace MarketoClient\LeadDatabase\Leads;

use MarketoClient\Endpoint;
use MarketoClient\Request;

/**
 * Retrieves a single lead record through it's Marketo id.
 * @see http://developers.marketo.com/rest-api/endpoint-reference/lead-database-endpoint-reference/#!/Leads/getLeadByIdUsingGET
 *
 * @property int $leadId
 * @property string|array|null $fields
 */
class FindLead extends Endpoint
{
    protected $uri = '/rest/v1/leads';

    protected $required = ['leadId'];

    public function send()
    {
        $this->checkRequired();

        $request = Request::post($this->url("/$this->leadId.json"))
            ->withHeaders($this->client->baseHeaders())
            ->withQueryValue('_method', 'GET')
            ->withFormParams($this->query());

        $response = $this->client->sendWithRetry($request);

        return $response;
    }

    public function leadId($value)
    {
        return $this->set(__FUNCTION__, $value);
    }

    public function fields($value)
    {
        return $this->set(__FUNCTION__, is_array($value) ? $value : func_get_args());
    }

    public function query()
    {
        if ($this->has('fields')) {
            return implode(',', $this->fields);
        }

        return [];
    }
}
