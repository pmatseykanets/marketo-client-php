<?php

namespace MarketoClient\LeadDatabase\Lists;

use MarketoClient\Request;
use MarketoClient\Endpoint;

/**
 * Checks if leads are members of a given static list.
 * @see http://developers.marketo.com/rest-api/endpoint-reference/lead-database-endpoint-reference/#!/Static_Lists/areLeadsMemberOfListUsingGET
 *
 * @property int $listId
 * @property array $leadIds
 */
class IsMemberOfList extends Endpoint
{
    protected $uri = '/rest/v1/lists';

    protected $required = ['listId', 'leadIds'];

    protected $exclude = ['listId'];

    public function send()
    {
        $this->checkRequired();

        $request = Request::get($this->url("/$this->listId/leads/ismember.json"))
            ->withHeaders($this->client()->baseHeaders())
            ->withJson([
                'input' => array_map(function ($id) {
                    return ['id' => $id];
                }, $this->leadIds),
            ]);

        $response = $this->client()->sendWithRetry($request);

        return $response;
    }

    public function listId($value)
    {
        return $this->set(__FUNCTION__, $value);
    }

    public function leadIds($value)
    {
        return $this->set(__FUNCTION__, is_array($value) ? $value : func_get_args());
    }
}
