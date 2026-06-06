<?php

namespace App\Domains\Common\Services;

use Closure;
use Illuminate\Support\Facades\DB;

/**
 * Base service providing shared functionality for domain services,
 * including a database transaction helper.
 */
abstract class BaseService
{
    /**
     * Run the given callback inside a database transaction.
     *
     * @template T
     * @param  Closure():T  $callback
     * @return T
     */
    protected function transaction(Closure $callback): mixed
    {
        return DB::transaction($callback);
    }
}
