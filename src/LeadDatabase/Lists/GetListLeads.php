<?php

namespace MarketoClient\LeadDatabase\Lists;

use MarketoClient\Request;
use MarketoClient\Endpoint;

/**
 * Retrieves person records which are members of the given static list.
 * @see http://developers.marketo.com/rest-api/endpoint-reference/lead-database-endpoint-reference/#!/Static_Lists/getLeadsByListIdUsingGET_1
 *
 * @property int $listId
 * @property string|array $fields
 * @property int|null $batchSize
 * @property string|null $nextPageToken
 */
class GetListLeads extends Endpoint
{
    protected $uri = '/rest/v1/lists';

    protected $required = ['listId'];

    protected $listable = ['fields'];

    protected $exclude = ['listId'];

    public function send()
    {
        do {
            $request = Request::post($this->url("/$this->listId/leads.json"))
                ->withHeaders($this->client->baseHeaders())
                ->withQueryValue('_method', 'GET')
                ->withFormParams($this->query());

            $response = $this->client->sendWithRetry($request);

            $this->nextPageToken($response->nextPageToken);

            yield $response;
        } while (isset($response->nextPageToken));
    }

    public function listId($value)
    {
        return $this->set(__FUNCTION__, $value);
    }

    public function fields($value)
    {
        return $this->set(__FUNCTION__, is_array($value) ? $value : func_get_args());
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
