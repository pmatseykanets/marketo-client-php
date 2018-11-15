<?php

namespace MarketoClient\LeadDatabase\Activities;

use DateTime;
use MarketoClient\Request;
use MarketoClient\Endpoint;

/**
 * Returns a list of available activity types in the target instance,
 * along with associated metadata of each type.
 * @see http://developers.marketo.com/rest-api/endpoint-reference/lead-database-endpoint-reference/#!/Activities/getAllActivityTypesUsingGET
 *
 * @property \DateTime|null $sinceDateTime
 * @property string|array|null $fields
 * @property int|null $listId
 * @property int|array|null $leadIds
 * @property int|null $batchSize
 * @property string|null $nextPageToken
 */
class GetLeadChangesActivities extends Endpoint
{
    protected $uri = '/rest/v1/activities';

    protected $required = ['nextPageToken', 'fields'];

    public function send()
    {
        if ($this->nextPageToken === null && $this->since !== null) {
            $pagingToken = GetPagingToken::new($this->client())
                ->since($this->since)
                ->send()
                ->nextPageToken;

            $this->nextPageToken($pagingToken);
        }

        $this->checkRequired();

        do {
            $request = Request::post($this->url('/leadchanges.json'))
                ->withHeaders($this->client->baseHeaders())
                ->withQueryValue('_method', 'GET')
                ->withFormParams($this->query());

            $response = $this->client->sendWithRetry($request);

            $this->nextPageToken($response->nextPageToken);

            yield $response;
        } while (isset($response->nextPageToken));
    }

    public function sinceDateTime($value)
    {
        return $this->set(__FUNCTION__, $value instanceof DateTime ? $value : new DateTime($value));
    }

    public function fields($value)
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
        foreach (['fields', 'leadIds'] as $parameter) {
            if ($this->has($parameter)) {
                $query[$parameter] = implode(',', $query[$parameter]);
            }
        }

        return $query;
    }
}
