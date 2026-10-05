<?php

namespace App\Domains\Tenant\Services;

use Illuminate\Support\Facades\DB;

class TenantSequenceService
{
    /**
     * Get the next atomic sequential number for a specific tenant and entity type.
     * Uses database row-level locking (lockForUpdate) for strict concurrency safety.
     *
     * @param  int  $tenantId
     * @param  string  $entityType ('sale', 'purchase', 'sale_return', 'purchase_return')
     * @return int
     */
    public function nextNumber(int $tenantId, string $entityType): int
    {
        return DB::transaction(function () use ($tenantId, $entityType) {
            $sequence = DB::table('tenant_sequences')
                ->where('tenant_id', $tenantId)
                ->where('entity_type', $entityType)
                ->lockForUpdate()
                ->first();

            if ($sequence === null) {
                $startingNumber = $this->calculateStartingNumber($tenantId, $entityType);
                $nextNumber = $startingNumber + 1;

                $inserted = DB::table('tenant_sequences')->insertOrIgnore([
                    'tenant_id'   => $tenantId,
                    'entity_type' => $entityType,
                    'last_number' => $nextNumber,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);

                if ($inserted === 0) {
                    // Race condition safeguard: Another thread inserted concurrently
                    $sequence = DB::table('tenant_sequences')
                        ->where('tenant_id', $tenantId)
                        ->where('entity_type', $entityType)
                        ->lockForUpdate()
                        ->first();

                    $nextNumber = (int) $sequence->last_number + 1;

                    DB::table('tenant_sequences')
                        ->where('id', $sequence->id)
                        ->update([
                            'last_number' => $nextNumber,
                            'updated_at'  => now(),
                        ]);
                }

                return $nextNumber;
            }

            $nextNumber = (int) $sequence->last_number + 1;

            DB::table('tenant_sequences')
                ->where('id', $sequence->id)
                ->update([
                    'last_number' => $nextNumber,
                    'updated_at'  => now(),
                ]);

            return $nextNumber;
        });
    }

    /**
     * Format the next sequential number with prefix and zero padding.
     */
    public function generateFormattedNumber(int $tenantId, string $entityType, ?string $customPrefix = null, int $padLength = 5): string
    {
        $number = $this->nextNumber($tenantId, $entityType);
        $prefix = $customPrefix ?? $this->resolveDefaultPrefix($tenantId, $entityType);

        return $prefix . str_pad((string) $number, $padLength, '0', STR_PAD_LEFT);
    }

    /**
     * If sequence row does not exist yet, find max numeric suffix from existing records for this tenant.
     */
    protected function calculateStartingNumber(int $tenantId, string $entityType): int
    {
        $column = match ($entityType) {
            'sale', 'purchase' => 'invoice_no',
            'sale_return', 'purchase_return' => 'return_no',
            default => null,
        };

        $table = match ($entityType) {
            'sale' => 'sales',
            'purchase' => 'purchases',
            'sale_return' => 'sale_returns',
            'purchase_return' => 'purchase_returns',
            default => null,
        };

        if (! $table || ! $column) {
            return 0;
        }

        $records = DB::table($table)
            ->where('tenant_id', $tenantId)
            ->whereNotNull($column)
            ->pluck($column);

        $maxNumber = 0;
        foreach ($records as $val) {
            if (preg_match('/(\d+)/', (string) $val, $matches)) {
                $num = (int) $matches[1];
                if ($num > $maxNumber) {
                    $maxNumber = $num;
                }
            }
        }

        return $maxNumber;
    }

    protected function resolveDefaultPrefix(int $tenantId, string $entityType): string
    {
        return match ($entityType) {
            'sale' => $this->getInvoicePrefix($tenantId),
            'purchase' => 'PUR-',
            'sale_return' => 'RET-',
            'purchase_return' => 'PRET-',
            default => '',
        };
    }

    protected function getInvoicePrefix(int $tenantId): string
    {
        $prefix = DB::table('settings')
            ->where('tenant_id', $tenantId)
            ->value('invoice_prefix');

        return ! empty($prefix) ? $prefix : 'INV-';
    }
}
