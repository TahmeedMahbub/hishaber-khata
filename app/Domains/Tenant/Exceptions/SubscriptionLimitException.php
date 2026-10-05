<?php

namespace App\Domains\Tenant\Exceptions;

use Exception;

class SubscriptionLimitException extends Exception
{
    public function __construct(
        string $message,
        public readonly string $limitType,
        public readonly ?int $limitValue = null,
        int $code = 403,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
