<?php

namespace MarketoClient;

abstract class Resource
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * Create a new instance.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function client()
    {
        return $this->client;
    }
}
