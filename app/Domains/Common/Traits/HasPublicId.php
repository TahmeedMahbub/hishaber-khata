<?php

namespace App\Domains\Common\Traits;

use Illuminate\Support\Str;

/**
 * Gives a model a short, public-facing identifier (`public_id`) so the
 * internal auto-increment `id` is never exposed to users.
 *
 * - Generates a unique 8-character `public_id` automatically on create.
 * - Uses `public_id` for route-model binding (URLs show the public id,
 *   not the sequential primary key).
 * - Hides the internal `id` from array/JSON serialization.
 *
 * The owning model must have a `public_id` column.
 *
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait HasPublicId
{
    /**
     * Number of characters in a generated public id.
     */
    protected static int $publicIdLength = 8;

    /**
     * Boot the trait: assign a unique public_id before the model is created.
     */
    public static function bootHasPublicId(): void
    {
        static::creating(function ($model): void {
            if (empty($model->public_id)) {
                $model->public_id = static::generatePublicId();
            }
        });
    }

    /**
     * Initialize the trait on each model instance: hide the internal id.
     */
    public function initializeHasPublicId(): void
    {
        if (! in_array('id', $this->getHidden(), true)) {
            $this->makeHidden('id');
        }
    }

    /**
     * Use public_id for implicit route-model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'public_id';
    }

    /**
     * Generate an 8-character alphanumeric public id that is unique
     * across the whole table (ignoring any global scopes).
     */
    public static function generatePublicId(): string
    {
        $instance = new static();

        do {
            $candidate = Str::lower(Str::random(static::$publicIdLength));
        } while (
            $instance->newQuery()
                ->withoutGlobalScopes()
                ->where('public_id', $candidate)
                ->exists()
        );

        return $candidate;
    }
}
