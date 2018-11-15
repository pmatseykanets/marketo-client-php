<?php

namespace MarketoClient;

use RuntimeException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ConnectException;
use MarketoClient\Exceptions\MarketoException;

class Client
{
    const CONFIG_CLIENT_ID = 'client_id';
    const CONFIG_CLIENT_SECRET = 'client_secret';
    const CONFIG_URL = 'url';
    const CONFIG_PARTNER_ID = 'partner_id';

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var ClientInterface
     */
    protected $http;

    /**
     * @var Store
     */
    protected $store;

    /**
     * Create a new instance.
     *
     * @param array $config
     * @param ClientInterface|null $http
     * @param Store|null $store
     */
    public function __construct($config = [], ClientInterface $http = null, Store $store = null)
    {
        $this->config[self::CONFIG_CLIENT_ID] = $config[self::CONFIG_CLIENT_ID] ?? getenv('MARKETO_CLIENT_ID');
        $this->config[self::CONFIG_CLIENT_SECRET] = $config[self::CONFIG_CLIENT_SECRET] ?? getenv('MARKETO_CLIENT_SECRET');
        $this->config[self::CONFIG_URL] = $config[self::CONFIG_URL] ?? getenv('MARKETO_URL');
        $this->config[self::CONFIG_PARTNER_ID] = $config[self::CONFIG_PARTNER_ID] ?? getenv('MARKETO_PARTNER_ID');

        $this->http = $http;
        $this->store = $store;
    }

    /**
     * Identity resources.
     *
     * @return Identity
     */
    public function identity()
    {
        return new Identity($this);
    }

    /**
     * LeadDatabase resources.
     *
     * @return LeadDatabase
     */
    public function leadDatabase()
    {
        return new LeadDatabase($this);
    }

    /**
     * Assets resources.
     *
     * @return Assets
     */
    public function assets()
    {
        return new Assets($this);
    }

    /**
     * Construct a URL using base URL.
     *
     * @param string $uri
     * @param array $query
     * @return string
     */
    public function url($uri = '', $query = [])
    {
        $baseUrl = $this->config(self::CONFIG_URL);
        $url = $baseUrl.$uri;

        if (! empty($query)) {
            $url .= '?'.http_build_query($query);
        }

        return $url;
    }


    /**
     * Returns base headers.
     *
     * @return array
     */
    public function baseHeaders()
    {
        return [
            'Authorization' => 'Bearer '.$this->accessToken(),
            'Accept-Encoding' => 'gzip',
        ];
    }

    /**
     * Accessor for the store.
     *
     * @return MemoryStore|Store|null
     */
    public function store()
    {
        if ($this->store === null) {
            $this->store = new MemoryStore();
        }

        return $this->store;
    }

    /**
     * Get an access token out of the store.
     *
     * @return AccessToken|mixed
     */
    public function accessToken()
    {
        $token = $this->store()->get('token');

        if ($token !== null && $token->isNotExpired()) {
            return $token;
        }

        return $this->renewAccessToken();
    }

    /**
     * Get a fresh access token and put it in a store.
     *
     * @return AccessToken
     */
    public function renewAccessToken()
    {
        $response = $this->identity()->getOAuthToken()->send();

        $token = AccessToken::fromResponse($response);

        $this->store()->put('token', $token);

        return $token;
    }

    /**
     * An accessor for an HTTP client.
     *
     * @return \GuzzleHttp\Client|ClientInterface|null
     */
    public function http()
    {
        if ($this->http === null) {
            $this->http = new \GuzzleHttp\Client();
        }

        return $this->http;
    }

    /**
     * Send a request with retry.
     *
     * @param Request $request
     * @throws MarketoException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return Response
     */
    public function sendWithRetry(Request $request)
    {
        $attempt = 0;
        $maxAttempts = $this->config('retry_attempts', 5);
        $previous = null;

        do {
            $attempt++;

            try {
                $response = $this->send($request);

                if (isset($response->success) && $response->success !== true) {
                    throw MarketoException::fromError($response->errors);
                }

                return $response;
            } catch (MarketoException $exception) {
//                dump($exception);
                $previous = $exception;

                // If Access Token has expired renew the token and retry right away
                if ($exception->getCode() === Error::ACCESS_TOKEN_EXPIRED) {
                    $this->renewAccessToken();
                    continue;
                }
                // If the error is recoverable exponentially back off and retry
                if ($exception->isRecoverable()) {
                    sleep(2 ** $attempt);
                    continue;
                }

                throw $exception;
            } catch (ConnectException $exception) {
//                dump($exception);
                $previous = $exception;
                // Try to recover from Network errors
                sleep(2 * $attempt);
                continue;
            }
        } while ($attempt <= $maxAttempts);

        // Couldn't recover
        throw new RuntimeException(sprintf("Request failed after %d attempts", $attempt), 0, $previous);
    }

    /**
     * Send a request.
     *
     * @param Request $request
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return Response
     */
    public function send(Request $request)
    {
        $start = microtime(true);
        $raw = $this->http()->request(
            $request->method(),
            $request->uri(),
            $request->options()
        );
        $duration = (int) ((microtime(true) - $start) * 1000);

        $response = new Response($raw);

        $this->store()->increment('total_calls');
        $this->store()->put('last_call_duration', $duration);

        return $response;
    }

    /**
     * Send request asynchronously.
     *
     * @param Request $request
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function sendAsync(Request $request)
    {
        $this->store()->increment('total_calls');

        return $this->http()->requestAsync(
            $request->method(),
            $request->uri(),
            $request->options()
        );
    }

    /**
     * An accessor for the config.
     *
     * @param null $key
     * @param null $default
     * @return array|mixed|null
     */
    public function config($key = null, $default = null)
    {
        if ($key !== null) {
            return $this->config[$key] ?? $default;
        }

        return $this->config;
    }
}
