<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Every business table that should expose a short, public-facing
     * identifier instead of its sequential primary key.
     */
    private array $tables = [
        'plans',
        'tenants',
        'subscriptions',
        'branches',
        'users',
        'categories',
        'products',
        'suppliers',
        'customers',
        'purchases',
        'purchase_items',
        'sales',
        'sale_items',
        'expense_categories',
        'expenses',
        'stock_movements',
        'cash_transactions',
        'damages',
        'activity_logs',
        'due_payments',
        'feedbacks',
        'notifications',
    ];

    /**
     * Add a nullable, unique `public_id` column to every table and
     * backfill a unique 8-character value for existing rows.
     */
    public function up(): void
    {
        foreach ($this->tables as $table) {
            if (! Schema::hasTable($table) || Schema::hasColumn($table, 'public_id')) {
                continue;
            }

            Schema::table($table, function (Blueprint $blueprint) use ($table) {
                $blueprint->char('public_id', 8)->nullable()->after('id');
                $blueprint->unique('public_id', $table . '_public_id_unique');
            });

            $this->backfill($table);
        }
    }

    /**
     * Assign a unique public_id to every existing row that lacks one.
     */
    private function backfill(string $table): void
    {
        $used = DB::table($table)
            ->whereNotNull('public_id')
            ->pluck('public_id')
            ->all();
        $used = array_flip($used);

        DB::table($table)
            ->whereNull('public_id')
            ->orderBy('id')
            ->select('id')
            ->chunkById(500, function ($rows) use ($table, &$used) {
                foreach ($rows as $row) {
                    do {
                        $candidate = Str::lower(Str::random(8));
                    } while (isset($used[$candidate]));

                    $used[$candidate] = true;

                    DB::table($table)->where('id', $row->id)->update([
                        'public_id' => $candidate,
                    ]);
                }
            });
    }

    /**
     * Drop the `public_id` column from every table.
     */
    public function down(): void
    {
        foreach ($this->tables as $table) {
            if (! Schema::hasTable($table) || ! Schema::hasColumn($table, 'public_id')) {
                continue;
            }

            Schema::table($table, function (Blueprint $blueprint) use ($table) {
                $blueprint->dropUnique($table . '_public_id_unique');
                $blueprint->dropColumn('public_id');
            });
        }
    }
};
