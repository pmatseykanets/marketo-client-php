<?php

if (! function_exists('array_wrap')) {
    /**
     * If the given value is not an array and not null, wrap it in one.
     *
     * @param  mixed $value
     * @return array
     */
    function array_wrap($value)
    {
        if (is_null($value)) {
            return [];
        }

        return is_array($value) ? $value : [$value];
    }
}

if (! function_exists('value')) {
    /**
     * Return the default value of the given value.
     *
     * @param  mixed  $value
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}

if (! function_exists('batch')) {
    /**
     * Batch iterable by size.
     *
     * @param iterable $iterable
     * @param $size
     * @return Generator
     */
    function batch(iterable &$iterable, $size)
    {
        $batch = [];
        $count = 0;

        foreach ($iterable as $value) {
            $batch[] = $value;
            $count++;

            if ($count >= $size) {
                yield $batch;
                $count = 0;
                $batch = [];
            }
        }

        yield $batch;
    }
}
