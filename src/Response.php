<?php

namespace MarketoClient;

use Psr\Http\Message\ResponseInterface;

/**
 * Class Response.
 *
 * @property bool success
 * @property string requestId
 * @property bool moreResult
 * @property string nextPageToken
 * @property mixed result
 * @property mixed errors
 * @property mixed warnings
 */
class Response
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var mixed
     */
    protected $body;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function response()
    {
        return $this->response;
    }

    public function body()
    {
        if (! $this->body) {
            $this->body = json_decode((string) $this->rawBody());
        }

        return $this->body;
    }

    public function rawBody()
    {
        return $this->response->getBody();
    }

    public function __get($name)
    {
        if (isset($this->body()->{$name})) {
            return $this->body()->{$name};
        }

        return null;
    }

    public function __isset($name)
    {
        return isset($this->body()->{$name});
    }
}
