<?php

namespace MarketoClient\LeadDatabase\Campaigns;

use MarketoClient\Request;
use MarketoClient\Endpoint;

/**
 * Returns a list of campaign records.
 * @see http://developers.marketo.com/rest-api/endpoint-reference/lead-database-endpoint-reference/#!/Campaigns/getCampaignsUsingGET
 *
 * @property int|array|null $id
 * @property string|array|null $name
 * @property string|array|null $programName
 * @property string|array|null $workspaceName
 * @property int|null $batchSize
 * @property string|null $nextPageToken
 * @property bool|null $isTriggerable
 */
class GetCampaigns extends Endpoint
{
    protected $uri = '/rest/v1/campaigns';

    protected $listable = ['id', 'name', 'programName', 'workspaceName'];

    public function send()
    {
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

    public function id($value)
    {
        return $this->set(__FUNCTION__, is_array($value) ? $value : func_get_args());
    }

    public function name($value)
    {
        return $this->set(__FUNCTION__, is_array($value) ? $value : func_get_args());
    }

    public function programName($value)
    {
        return $this->set(__FUNCTION__, is_array($value) ? $value : func_get_args());
    }

    public function workspaceName($value)
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

    public function isTriggerable($value)
    {
        return $this->set(__FUNCTION__, $value);
    }
}
