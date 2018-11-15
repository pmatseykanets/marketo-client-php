<?php

namespace MarketoClient\LeadDatabase\Activities;

use DateTime;
use MarketoClient\Endpoint;
use MarketoClient\Request;

/**
 * Class PagingToken.
 *
 * @property DateTime $sinceDateTime
 */
class GetPagingToken extends Endpoint
{
    protected $uri = '/rest/v1/activities';

    protected $required = ['sinceDateTime'];

    public function send()
    {
        $this->checkRequired();

        $request = Request::get($this->url("/pagingtoken.json"))
            ->withHeaders($this->client->baseHeaders())
            ->withQueryValue('sinceDatetime', $this->sinceDateTime->format(DATE_ISO8601));

        $response = $this->client->sendWithRetry($request);

        return $response;
    }

    public function sinceDateTime($value)
    {
        return $this->set(__FUNCTION__, $value instanceof DateTime ? $value : new DateTime($value));
    }
}
