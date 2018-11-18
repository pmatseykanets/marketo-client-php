<?php

namespace MarketoClient\LeadDatabase\Campaigns;

use MarketoClient\Request;
use MarketoClient\Endpoint;

/**
 * Returns the record of a campaign by its id.
 * @see http://developers.marketo.com/rest-api/endpoint-reference/lead-database-endpoint-reference/#!/Campaigns/getCampaignByIdUsingGET
 *
 * @property int $id
 */
class FindCampaign extends Endpoint
{
    protected $uri = '/rest/v1/campaigns';

    protected $required = ['id'];

    public function send()
    {
        $this->checkRequired();

        $request = Request::get($this->url("/$this->id.json"))
            ->withHeaders($this->client->baseHeaders());

        $response = $this->client->sendWithRetry($request);

        return $response;
    }

    public function id($value)
    {
        return $this->set(__FUNCTION__, $value);
    }
}
