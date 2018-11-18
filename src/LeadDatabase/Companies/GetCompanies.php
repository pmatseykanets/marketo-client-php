<?php

namespace MarketoClient\LeadDatabase\Companies;

use MarketoClient\Request;
use MarketoClient\Endpoint;

/**
 * Retrieves company records from the destination instance based on the submitted filter.
 * @see http://developers.marketo.com/rest-api/endpoint-reference/lead-database-endpoint-reference/#!/Companies/getCompaniesUsingGET
 *
 * @property string $filterType
 * @property string|array $filterValues
 * @property string|array $fields
 * @property int|null $batchSize
 * @property string|null $nextPageToken
 */
class GetCompanies extends Endpoint
{
    protected $uri = '/rest/v1/companies';

    protected $listable = ['filterValues', 'fields'];

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
        } while ($response->hasMorePages());
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
