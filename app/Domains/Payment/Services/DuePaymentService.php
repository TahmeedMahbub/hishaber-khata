<?php

namespace App\Domains\Payment\Services;

use App\Domains\Common\Services\BaseService;
use App\Domains\Customer\Models\Customer;
use App\Domains\Payment\Models\DuePayment;
use App\Domains\Payment\Repositories\DuePaymentRepository;
use App\Domains\Supplier\Models\Supplier;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class DuePaymentService extends BaseService
{
    public function __construct(protected DuePaymentRepository $payments)
    {
    }

    public function paginate(?string $partyType = null): LengthAwarePaginator
    {
        return $this->payments->list($partyType);
    }

    /**
     * Record a due payment and reduce the party's outstanding balance.
     *
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): DuePayment
    {
        return $this->transaction(function () use ($data) {
            $partyType = $data['party_type'];
            $partyId   = (int) $data['party_id'];
            $amount    = round((float) $data['amount'], 2);

            $party = $this->resolveParty($partyType, $partyId);

            // Never let the balance fall below zero.
            $reduction = min($amount, (float) $party->due_balance);
            if ($reduction > 0) {
                $party->decrement('due_balance', $reduction);
            }

            $user = Auth::user();

            return $this->payments->create([
                'branch_id'    => $user->branch_id ?? null,
                'user_id'      => $user->id ?? null,
                'party_type'   => $partyType,
                'party_id'     => $partyId,
                'amount'       => $amount,
                'method'       => $data['method'] ?? 'cash',
                'payment_date' => $data['payment_date'] ?? now()->toDateString(),
                'note'         => $data['note'] ?? null,
            ]);
        });
    }

    /**
     * Delete a payment and restore the party's balance.
     */
    public function delete(DuePayment $payment): bool
    {
        return $this->transaction(function () use ($payment) {
            $party = $this->resolveParty($payment->party_type, (int) $payment->party_id);
            $party->increment('due_balance', (float) $payment->amount);

            return (bool) $payment->delete();
        });
    }

    /**
     * Resolve the customer or supplier the payment belongs to.
     */
    protected function resolveParty(string $partyType, int $partyId): Customer|Supplier
    {
        return $partyType === 'customer'
            ? Customer::findOrFail($partyId)
            : Supplier::findOrFail($partyId);
    }
}
