<?php

namespace MarketoClient;

class Request
{
    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var
     */
    protected $bodyType = 'body';

    /**
     * @var array
     */
    protected $bodyTypes = ['body', 'form_params', 'multipart', 'json'];

    public function __construct($method = 'GET', $uri = '', $options = [])
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->options = $options;
    }

    public function newRequest()
    {
        return new static($this->method, $this->uri, $this->options);
    }

    public static function get($uri = '', $options = [])
    {
        return new static('GET', $uri, $options);
    }

    public static function post($uri = '', $options = [])
    {
        return new static('POST', $uri, $options);
    }

    public static function delete($uri = '', $options = [])
    {
        return new static('DELETE', $uri, $options);
    }

    public function method()
    {
        return $this->method;
    }

    public function uri()
    {
        return $this->uri;
    }

    public function headers()
    {
        return $this->option('headers') ?: [];
    }

    public function header($key)
    {
        return $this->headers()[$key] ?? null;
    }

    public function withHeaders(array $headers)
    {
        $this->withOption('headers', array_merge($this->headers(), $headers));

        return $this;
    }

    public function withHeader($key, $value)
    {
        $this->withOption('headers', array_merge($this->headers(), [$key => $value]));

        return $this;
    }

    public function query()
    {
        return $this->option('query') ?: [];
    }

    public function queryValue($key)
    {
        return $this->query()[$key] ?? [];
    }

    public function withQuery(array $query)
    {
        $this->withOption('query', array_merge($this->query(), $query));

        return $this;
    }

    public function withQueryValue($key, $value = null)
    {
        $this->withQuery(array_merge($this->query(), [$key => $value]));

        return $this;
    }

    public function withoutQueryValue($key)
    {
        unset($this->options['query'][$key]);

        return $this;
    }

    public function hasQueryValue($key)
    {
        return isset($this->query()[$key]);
    }

    public function option($key)
    {
        return $this->options[$key] ?? null;
    }

    public function options()
    {
        return $this->options;
    }

    public function withOption($key, $value)
    {
        $this->options[$key] = $value;

        return $this;
    }

    public function withoutOption($key)
    {
        unset($this->options[$key]);

        return $this;
    }

    public function hasOption($key)
    {
        return isset($this->options[$key]);
    }

    public function body()
    {
        return $this->option($this->bodyType);
    }

    public function withBody($value)
    {
        return $this->setBody('body', $value);
    }

    public function withJson($value)
    {
        return $this->setBody('json', $value);
    }

    public function withMultipart($value)
    {
        return $this->setBody('multipart', $value);
    }

    public function withFormParams($value)
    {
        return $this->setBody('form_params', $value);
    }

    public function withoutBody()
    {
        $this->withoutOption($this->bodyType);
        $this->bodyType = 'body';

        return $this;
    }

    protected function setBody($type, $value)
    {
        foreach (array_diff($this->bodyTypes, [$type]) as $key) {
            $this->withoutOption($key);
        }

        $this->withOption($type, $value);
        $this->bodyType = $type;

        return $this;
    }
}
