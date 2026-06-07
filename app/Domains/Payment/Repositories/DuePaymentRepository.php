<?php

namespace App\Domains\Payment\Repositories;

use App\Domains\Common\Repositories\BaseRepository;
use App\Domains\Payment\Models\DuePayment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DuePaymentRepository extends BaseRepository
{
    public function __construct(DuePayment $model)
    {
        parent::__construct($model);
    }

    /**
     * Paginated list for the current tenant, optionally filtered by party type.
     */
    public function list(?string $partyType = null, int $perPage = 15): LengthAwarePaginator
    {
        return $this->query()
            ->when($partyType, fn ($q) => $q->where('party_type', $partyType))
            ->orderByDesc('payment_date')
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();
    }
}
