<?php

namespace App\Domains\Tenant\Models;

use App\Domains\Common\Traits\BelongsToTenant;
use App\Domains\Common\Traits\HasPublicId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setting extends Model
{
    use BelongsToTenant, HasPublicId;

    protected $fillable = [
        'tenant_id',
        'language',
        'currency',
        'currency_symbol',
        'date_format',
        'timezone',
        'track_stock',
        'low_stock_alert',
        'allow_negative_stock',
        'enable_barcode',
        'show_profit',
        'enable_due',
        'invoice_prefix',
    ];

    protected $casts = [
        'track_stock'          => 'boolean',
        'low_stock_alert'      => 'boolean',
        'allow_negative_stock' => 'boolean',
        'enable_barcode'       => 'boolean',
        'show_profit'          => 'boolean',
        'enable_due'           => 'boolean',
    ];

    /**
     * Default business preference values, mirroring the column defaults.
     *
     * @var array<string, bool|string>
     */
    public const DEFAULTS = [
        'language'             => 'bn',
        'currency'             => 'BDT',
        'currency_symbol'      => '৳',
        'date_format'          => 'd/m/Y',
        'timezone'             => 'Asia/Dhaka',
        'track_stock'          => true,
        'low_stock_alert'      => true,
        'allow_negative_stock' => false,
        'enable_barcode'       => false,
        'show_profit'          => true,
        'enable_due'           => true,
        'invoice_prefix'       => 'INV-',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
