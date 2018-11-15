<?php

namespace MarketoClient\LeadDatabase\Activities;

use DateTime;
use MarketoClient\Endpoint;
use MarketoClient\Request;

/**
 * Returns a list of leads deleted after a given datetime.
 * NOTE: Deletions greater than 30 days old may be pruned.
 * @see http://developers.marketo.com/rest-api/endpoint-reference/lead-database-endpoint-reference/#!/Activities/getDeletedLeadsUsingGET
 *
 * @property \DateTime|null $sinceDateTime
 * @property int|null $batchSize
 * @property string|null $nextPageToken
 */
class GetDeletedLeadActivities extends Endpoint
{
    protected $uri = '/rest/v1/activities';

    protected $required = ['nextPageToken'];

    public function send()
    {
        if ($this->nextPageToken === null && $this->sinceDateTime !== null) {
            $pagingToken = GetPagingToken::new($this->client())
                ->sinceDateTime($this->sinceDateTime)
                ->send()
                ->nextPageToken;

            $this->nextPageToken($pagingToken);
        }

        $this->checkRequired();

        do {
            $request = Request::get($this->url('/deletedleads.json'))
                ->withHeaders($this->client->baseHeaders())
                ->withQuery($this->query());

            $response = $this->client->sendWithRetry($request);

            $this->nextPageToken($response->nextPageToken);

            yield $response;
        } while (isset($response->nextPageToken));
    }

    public function sinceDateTime($value)
    {
        return $this->set(__FUNCTION__, $value instanceof DateTime ? $value : new DateTime($value));
    }

    public function batchSize($value)
    {
        return $this->set(__FUNCTION__, $value);
    }

    public function nextPageToken($value)
    {
        return $this->set(__FUNCTION__, $value);
    }

    public function query()
    {
        $query = $this->parameters();
        unset($query['sinceDateTime']);

        return $query;
    }
}
