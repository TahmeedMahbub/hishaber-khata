<?php

namespace App\Domains\Tenant\Exceptions;

use Exception;

class FeatureRestrictedException extends Exception
{
    public function __construct(
        string $message,
        public readonly string $featureKey,
        int $code = 403,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
