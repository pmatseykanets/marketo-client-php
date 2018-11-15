<?php

namespace Tests\LeadDatabase\Activities;

use MarketoClient\LeadDatabase\Activities\GetActivities;
use PHPUnit\Framework\TestCase;
use Tests\TestClient;

class GetActivitiesTest extends TestCase
{
    public function test_activity_type_ids()
    {
        $endpoint = new GetActivities(new TestClient());

        $endpoint->activityTypeIds(1, 2);
        $this->assertEquals([1, 2], $endpoint->activityTypeIds);
        $endpoint->activityTypeIds([1, 2]);
        $this->assertEquals([1, 2], $endpoint->activityTypeIds);
    }

    public function test_asset_ids()
    {
        $endpoint = new GetActivities(new TestClient());

        $endpoint->assetIds(1, 2);
        $this->assertEquals([1, 2], $endpoint->assetIds);
        $endpoint->assetIds([1, 2]);
        $this->assertEquals([1, 2], $endpoint->assetIds);
    }

    public function test_list_ids()
    {
        $endpoint = new GetActivities(new TestClient());

        $endpoint->listId(1);
        $this->assertEquals(1, $endpoint->listId);
    }

    public function test_leads_ids()
    {
        $endpoint = new GetActivities(new TestClient());

        $endpoint->leadIds(1, 2);
        $this->assertEquals([1, 2], $endpoint->leadIds);
        $endpoint->leadIds([1, 2]);
        $this->assertEquals([1, 2], $endpoint->leadIds);
    }

    public function test_batch_size()
    {
        $endpoint = new GetActivities(new TestClient());

        $endpoint->batchSize(10);
        $this->assertEquals(10, $endpoint->batchSize);
    }

    public function test_next_page_token()
    {
        $endpoint = new GetActivities(new TestClient());

        $endpoint->nextPageToken('foo');
        $this->assertEquals('foo', $endpoint->nextPageToken);
    }

    public function test_query()
    {
        $endpoint = new GetActivities(new TestClient());

        $endpoint
            ->activityTypeIds(1, 2)
            ->assetIds(3, 4)
            ->listId(5)
            ->leadIds(6, 7)
            ->batchSize(8)
            ->nextPageToken('foo');

        $this->assertEquals([
            'activityTypeIds' => '1,2',
            'assetIds' => '3,4',
            'listId' => 5,
            'leadIds' => '6,7',
            'batchSize' => 8,
            'nextPageToken' => 'foo',
        ], $endpoint->query());
    }
}
