<?php

namespace MarketoClient;

interface Store
{
    /**
     * @param $key
     * @return bool
     */
    public function has($key);

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function put($key, $value);

    /**
     * @param string $key
     * @return int
     */
    public function increment($key);
}
