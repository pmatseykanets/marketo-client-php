<?php

namespace MarketoClient;

use InvalidArgumentException;

abstract class Endpoint
{
    /**
     * Client instance.
     *
     * @var Client
     */
    protected $client;

    /**
     * Base URI.
     *
     * @var string
     */
    protected $uri = '';

    /**
     * Parameters.
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * Required parameters.
     *
     * @var array
     */
    protected $required = [];

    /**
     * @var array
     */
    protected $listable = [];

    /**
     * @var array
     */
    protected $exclude = [];

    /**
     * Create a new instance.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Create a new instance.
     *
     * @param Client $client
     * @return Endpoint
     */
    public static function new(Client $client)
    {
        return new static($client);
    }

    /**
     * @return array
     */
    public function query()
    {
        $query = $this->parameters();

        foreach ($this->listable as $parameter) {
            if ($this->has($parameter)) {
                $query[$parameter] = implode(',', $query[$parameter]);
            }
        }

        foreach ($this->exclude as $parameter) {
            unset($query[$parameter]);
        }

        return $query;
    }

    /**
     * Returns all parameters.
     *
     * @return array
     */
    public function parameters()
    {
        return $this->parameters;
    }

    /**
     * @param string $path
     * @param array $query
     * @return string
     */
    public function url($path = '', $query = [])
    {
        return $this->client->url($this->uri.$path, $query);
    }

    /**
     * @return Client
     */
    public function client()
    {
        return $this->client;
    }

    /**
     * Is parameter exists.
     *
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        return isset($this->parameters[$key]);
    }

    /**
     * Get a parameter from the container.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (array_key_exists($key, $this->parameters)) {
            return $this->parameters[$key];
        }

        return \value($default);
    }

    /**
     * Set a parameter value.
     *
     * @param $key
     * @param $value
     */
    protected function set($key, $value)
    {
        if ($value === null) {
            if (array_key_exists($key, $this->parameters)) {
                unset($this->parameters[$key]);
            }
        } else {
            $this->parameters[$key] = $value;
        }

        return $this;
    }

    /**
     * Check if all required parameters has values set.
     *
     * @throws InvalidArgumentException
     */
    public function checkRequired()
    {
        foreach ($this->required as $parameter) {
            if ($this->get($parameter) === null) {
                throw new InvalidArgumentException(sprintf('Required parameter %s is missing', $parameter));
            }
        }
    }

    /**
     * Dynamically retrieve the value of a parameter.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }
}
