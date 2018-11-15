<?php

namespace MarketoClient;

use MarketoClient\Identity\GetOAuthToken;

class Identity extends Resource
{
    public function getOAuthToken()
    {
        return new GetOAuthToken($this->client);
    }
}
