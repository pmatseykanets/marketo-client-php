<?php

namespace MarketoClient\LeadDatabase\Activities;

use DateTime;
use MarketoClient\Request;
use MarketoClient\Endpoint;

/**
 * Returns a list of activities from after a datetime given by the nextPageToken parameter.
 * Also allows for filtering by lead static list membership, or by a list of up to 30 lead ids.
 * @see http://developers.marketo.com/rest-api/endpoint-reference/lead-database-endpoint-reference/#!/Activities/getLeadActivitiesUsingGET
 *
 * @property \DateTime|null $sinceDateTime
 * @property int|array|null $activityTypeIds
 * @property int|array|null $assetIds
 * @property int|null $listId
 * @property int|array|null $leadIds
 * @property int|null $batchSize
 * @property string|null $nextPageToken
 */
class GetActivities extends Endpoint
{
    protected $uri = '/rest/v1/activities';

    protected $required = ['nextPageToken', 'activityTypeIds'];

    public function send()
    {
        if ($this->nextPageToken === null && $this->since !== null) {
            $pagingToken = GetPagingToken::new($this->client())
                ->sinceDateTime($this->sinceDateTime)
                ->send()
                ->nextPageToken;

            $this->nextPageToken($pagingToken);
        }

        $this->checkRequired();

        do {
            $request = Request::get($this->url('.json'))
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

    public function activityTypeIds($value)
    {
        return $this->set(__FUNCTION__, is_array($value) ? $value : func_get_args());
    }

    public function assetIds($value)
    {
        return $this->set(__FUNCTION__, is_array($value) ? $value : func_get_args());
    }

    public function listId($value)
    {
        return $this->set(__FUNCTION__, $value);
    }

    public function leadIds($value)
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

    public function query()
    {
        $query = $this->parameters();
        unset($query['sinceDateTime']);

        // Turn parameters into comma separated lists
        foreach (['activityTypeIds', 'assetIds', 'leadIds'] as $parameter) {
            if ($this->has($parameter)) {
                $query[$parameter] = implode(',', $query[$parameter]);
            }
        }

        return $query;
    }
}
