<?php

namespace MarketoClient;

use MarketoClient\LeadDatabase\Leads\FindLead;
use MarketoClient\LeadDatabase\Lists\FindList;
use MarketoClient\LeadDatabase\Lists\GetLists;
use MarketoClient\LeadDatabase\Leads\GetLeads;
use MarketoClient\LeadDatabase\Leads\PushLeads;
use MarketoClient\LeadDatabase\Leads\SyncLeads;
use MarketoClient\LeadDatabase\Lists\AddToList;
use MarketoClient\LeadDatabase\Leads\MergeLeads;
use MarketoClient\LeadDatabase\Leads\DeleteLeads;
use MarketoClient\LeadDatabase\Lists\GetListLeads;
use MarketoClient\LeadDatabase\Leads\DescribeLead;
use MarketoClient\LeadDatabase\Lists\IsListMember;
use MarketoClient\LeadDatabase\Leads\AssociateLead;
use MarketoClient\LeadDatabase\Lists\DeleteFromList;
use MarketoClient\LeadDatabase\Leads\GetLeadPartitions;
use MarketoClient\LeadDatabase\Activities\GetActivities;
use MarketoClient\LeadDatabase\Activities\GetPagingToken;
use MarketoClient\LeadDatabase\Leads\UpdateLeadPartition;
use MarketoClient\LeadDatabase\Activities\GetActivityTypes;
use MarketoClient\LeadDatabase\Activities\GetDeletedLeadActivities;
use MarketoClient\LeadDatabase\Activities\GetLeadChangesActivities;

class LeadDatabase extends Resource
{
    // Activities
    public function getActivities()
    {
        return new GetActivities($this->client);
    }

    public function getActivityTypes()
    {
        return new GetActivityTypes($this->client);
    }

    public function getDeletedLeadActivities()
    {
        return new GetDeletedLeadActivities($this->client);
    }

    public function getLeadChangesActivities()
    {
        return new GetLeadChangesActivities($this->client);
    }

    public function getPagingToken()
    {
        return new GetPagingToken($this->client);
    }

    // Leads
    public function associateLead()
    {
        return new AssociateLead($this->client);
    }

    public function deleteLeads()
    {
        return new DeleteLeads($this->client);
    }

    public function describeLead()
    {
        return new DescribeLead($this->client);
    }

    public function findLead()
    {
        return new FindLead($this->client);
    }

    public function getLeadPartitions()
    {
        return new GetLeadPartitions($this->client);
    }

    public function getLeads()
    {
        return new GetLeads($this->client);
    }

    public function mergeLeads()
    {
        return new MergeLeads($this->client);
    }

    public function pushLeads()
    {
        return new PushLeads($this->client);
    }

    public function syncLeads()
    {
        return new SyncLeads($this->client);
    }

    public function updateLeadPartition()
    {
        return new UpdateLeadPartition($this->client);
    }

    // Lists
    public function addToList()
    {
        return new AddToList($this->client);
    }

    public function deleteFromList()
    {
        return new DeleteFromList($this->client);
    }

    public function findList()
    {
        return new FindList($this->client);
    }

    public function getListLeads()
    {
        return new GetListLeads($this->client);
    }

    public function getLists()
    {
        return new GetLists($this->client);
    }

    public function isListMember()
    {
        return new IsListMember($this->client);
    }
}
