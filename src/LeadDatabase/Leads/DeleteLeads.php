<?php

namespace MarketoClient\LeadDatabase\Leads;

use MarketoClient\Endpoint;
use MarketoClient\Request;

/**
 * Delete a list of leads from the destination instance.
 * @see http://developers.marketo.com/rest-api/endpoint-reference/lead-database-endpoint-reference/#!/Leads/deleteLeadsUsingPOST
 *
 * @property iterable $leadIds
 */
class DeleteLeads extends Endpoint
{
    protected $uri = '/rest/v1/leads';

    protected $required = ['leadIds'];

    public function send()
    {
        // Read ids in batches of 300
        foreach ($this->batchLeadIds($this->leadIds, 300) as $batch) {
            $request = Request::post($this->url("/delete.json"))
                ->withHeaders($this->client()->baseHeaders())
                ->withJson([
                    'input' => $batch,
                ]);

            $response = $this->client()->sendWithRetry($request);

            yield $response;
        }
    }

    public function leadIds($value)
    {
        return $this->set(__FUNCTION__, is_iterable($value) ? $value : func_get_args());
    }

    protected function batchLeadIds(iterable &$leadIds, $size)
    {
        $mapped = [];
        $count = 0;
        foreach ($leadIds as $id) {
            $mapped[] = ['id' => $id];
            $count++;

            if ($count >= $size) {
                yield $mapped;
                $count = 0;
                $mapped = [];
            }
        }
        yield $mapped;
    }
}
