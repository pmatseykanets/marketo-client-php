<?php

namespace MarketoClient\LeadDatabase\Leads;

use MarketoClient\Request;
use MarketoClient\Endpoint;

/**
 * Merges two or more known lead records into a single lead record.
 * @see http://developers.marketo.com/rest-api/endpoint-reference/lead-database-endpoint-reference/#!/Leads/mergeLeadsUsingPOST
 *
 * @property int $leadId Id of the winning lead
 * @property int $leadIds Ids of loosing leads
 * @property boolean|null $mergeInCRM
 */
class MergeLeads extends Endpoint
{
    protected $uri = '/rest/v1/leads';

    protected $required = ['leadId', 'leadIds'];

    public function send()
    {
        $this->checkRequired();

        $request = Request::post($this->url("/{$this->leadId}/merge.json"))
            ->withHeaders($this->client->baseHeaders())
            ->withHeader('content-type', 'application/json')
            ->withQuery($this->query());

        $response = $this->client->sendWithRetry($request);

        return $response;
    }

    public function leadId($value)
    {
        return $this->set(__FUNCTION__, $value);
    }

    public function leadIds($value)
    {
        return $this->set(__FUNCTION__, is_array($value) ? $value : func_get_args());
    }

    public function mergeInCRM($value)
    {
        return $this->set(__FUNCTION__, $value === true ? true : null);
    }

    public function query()
    {
        $query = ['leadIds' => implode(',', $this->leadIds)];

        if ($this->has('mergeInCRM') && $this->mergeInCRM === true) {
            $query['mergeInCRM'] = 'true';
        }

        return $query;
    }
}
