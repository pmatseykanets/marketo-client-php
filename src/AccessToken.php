<?php

namespace MarketoClient;

use DateInterval;
use DateTime;

class AccessToken
{
    /**
     * @var string
     */
    protected $accessToken;
    /**
     * @var int
     */
    protected $expiresIn;
    /**
     * @var string
     */
    protected $type;
    /**
     * @var string
     */
    protected $scope;
    /**
     * @var DateTime
     */
    protected $timestamp;

    /**
     * Create a new instance.
     *
     * @param string $accessToken
     * @param int $expiresIn
     * @param string $type
     * @param string $scope
     * @param DateTime|null $timestamp
     */
    public function __construct($accessToken, $expiresIn, $type, $scope, $timestamp = null)
    {
        $this->accessToken = $accessToken;
        $this->expiresIn = $expiresIn;
        $this->type = $type;
        $this->scope = $scope;
        $this->timestamp = $timestamp ?: new DateTime();
    }

    /**
     * Create a new instance from a response object.
     *
     * @param Response $response
     * @return AccessToken
     */
    public static function fromResponse(Response $response)
    {
        return new static(
            $response->body()->access_token,
            $response->body()->expires_in,
            $response->body()->token_type,
            $response->body()->scope
        );
    }

    /**
     * @throws \Exception
     * @return bool
     */
    public function isExpired()
    {
        return (new DateTime())->sub(new DateInterval("PT{$this->expiresIn}S")) > $this->timestamp;
    }

    /**
     * @throws \Exception
     * @return bool
     */
    public function isNotExpired()
    {
        return ! $this->isExpired();
    }

    public function __get($key)
    {
        return $this->{$key};
    }

    public function __toString()
    {
        return $this->accessToken;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'access_token' => $this->accessToken,
            'expires_in' => $this->expiresIn,
            'type' => $this->type,
            'scope' => $this->scope,
        ];
    }
}
