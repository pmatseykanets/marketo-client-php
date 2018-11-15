<?php

namespace MarketoClient\LeadDatabase\Leads;

use MarketoClient\Endpoint;
use MarketoClient\Request;

/**
 * Returns a list of up to 300 leads based on a list of values in a particular field.
 * @see http://developers.marketo.com/rest-api/endpoint-reference/lead-database-endpoint-reference/#!/Leads/getLeadsByFilterUsingGET
 *
 * @property string $filterType
 * @property string|array $filterValues
 * @property string|array $fields
 * @property int|null $batchSize
 * @property string|null $nextPageToken
 */
class GetLeads extends Endpoint
{
    protected $uri = '/rest/v1/leads';

    protected $required = ['filterType', 'filterValues'];

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

    public function filterType($value)
    {
        return $this->set(__FUNCTION__, $value);
    }

    public function filterValues($value)
    {
        return $this->set(__FUNCTION__, is_array($value) ? $value : func_get_args());
    }

    public function fields($value)
    {
        return $this->set(__FUNCTION__, is_array($value) ? $value : func_get_args());
    }

    public function allFields()
    {
        // Use Describe endpoint to pull all the fields
        // TBD
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
