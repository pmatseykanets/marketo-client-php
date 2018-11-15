<?php

namespace MarketoClient\Exceptions;

use Exception;
use MarketoClient\Error;

class MarketoException extends Exception
{
    public $recoverable = [
        Error::ACCESS_TOKEN_EXPIRED,
        Error::REQUEST_TIMED_OUT,
        Error::RATE_LIMIT_EXCEEDED,
        Error::CONCURRENT_LIMIT_REACHED,
        Error::TOO_MANY_IMPORTS,
    ];

    public static function fromError($errors)
    {
        if ($errors === null) {
            return null;
        }

        $errors = is_array($errors) ? $errors : [$errors];

        $exception = null;

        foreach (array_reverse($errors) as $error) {
            $exception = new MarketoException($error->message, $error->code, $exception);
        }

        return $exception;
    }

    /**
     * Is the Marketo error recoverable.
     * @see http://developers.marketo.com/rest-api/error-codes/
     *
     * @return bool
     */
    public function isRecoverable()
    {
        return in_array($this->getCode(), $this->recoverable);
    }

    /**
     * Is the Marketo error unrecoverable.
     *
     * @return bool
     */
    public function isNotRecoverable()
    {
        return ! $this->isRecoverable();
    }
}
