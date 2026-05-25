<?php

namespace App\Exceptions;

use Exception;

class ApiException extends Exception
{
    protected $errorCode;
    protected $httpCode;
    protected $errors;

    public function __construct(
        string $message = 'An error occurred',
        int $httpCode = 400,
        string $errorCode = 'INTERNAL_ERROR',
        array $errors = [],
        Exception $previous = null
    ) {
        parent::__construct($message, 0, $previous);

        $this->httpCode = $httpCode;
        $this->errorCode = $errorCode;
        $this->errors = $errors;
    }

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
