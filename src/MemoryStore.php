<?php

namespace MarketoClient;

class MemoryStore implements Store
{
    protected $store = [];

    /**
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $this->store);
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (! $this->has($key)) {
            return $default;
        }

        return $this->store[$key] ?: $default;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function put($key, $value = null)
    {
        $this->store[$key] = $value;
    }

    /**
     * @param string $key
     * @return int
     */
    public function increment($key)
    {
        $value = (int) $this->get($key, 0);
        $value++;
        $this->put($key, $value);

        return $value;
    }
}
