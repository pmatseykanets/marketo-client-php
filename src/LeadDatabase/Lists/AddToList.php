<?php

namespace MarketoClient\LeadDatabase\Lists;

use MarketoClient\Request;
use MarketoClient\Endpoint;

/**
 * Adds a given set of person records to a target static list.
 * @see http://developers.marketo.com/rest-api/endpoint-reference/lead-database-endpoint-reference/#!/Static_Lists/addLeadsToListUsingPOST
 *
 * @property int $listId
 * @property array $leadIds
 */
class AddToList extends Endpoint
{
    protected $uri = '/rest/v1/lists';

    protected $required = ['listId', 'leadIds'];

    protected $exclude = ['listId'];

    public function send()
    {
        $this->checkRequired();

        $request = Request::post($this->url("/$this->listId/leads.json"))
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
