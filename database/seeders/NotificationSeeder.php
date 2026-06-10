<?php

namespace Database\Seeders;

use App\Domains\Notification\Models\Notification;
use App\Domains\Tenant\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Target identifiers requested for the demo data.
     */
    private const TENANT_ID = 4;

    private const USER_ID = 4;

    /**
     * Seed 10 notifications for tenant 4 / user 4.
     *
     * Demonstrates both visibility rules:
     *  - tenant-wide  : tenant_id = 4, user_id = null  (all users of tenant 4)
     *  - personal     : tenant_id = null, user_id = 4  (only user 4)
     */
    public function run(): void
    {
        $tenantExists = Tenant::query()->whereKey(self::TENANT_ID)->exists();
        $userExists   = User::query()->whereKey(self::USER_ID)->exists();

        if (! $tenantExists) {
            $this->command?->warn('NotificationSeeder: tenant #' . self::TENANT_ID . ' not found, skipping tenant-wide notifications.');
        }

        if (! $userExists) {
            $this->command?->warn('NotificationSeeder: user #' . self::USER_ID . ' not found, skipping personal notifications.');
        }

        if (! $tenantExists && ! $userExists) {
            return;
        }

        foreach ($this->rows() as $row) {
            // Personal notification (no tenant) requires user 4 to exist.
            if ($row['tenant_id'] === null && ! $userExists) {
                continue;
            }

            // Tenant-wide notification requires tenant 4 to exist.
            if ($row['tenant_id'] !== null && ! $tenantExists) {
                continue;
            }

            Notification::create($row);
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function rows(): array
    {
        return [
            // ----- Tenant-wide notifications (shown to every user of tenant 4) -----
            [
                'tenant_id' => self::TENANT_ID,
                'user_id'   => null,
                'type'      => 'sale',
                'title'     => 'নতুন বিক্রয় সম্পন্ন হয়েছে',
                'message'   => 'আজ একটি নতুন বিক্রয় রেকর্ড করা হয়েছে।',
                'url'       => null,
                'read_at'   => null,
                'created_at' => now()->subMinutes(5),
                'updated_at' => now()->subMinutes(5),
            ],
            [
                'tenant_id' => self::TENANT_ID,
                'user_id'   => null,
                'type'      => 'stock',
                'title'     => 'স্টক কমে গেছে',
                'message'   => 'কিছু পণ্যের স্টক সর্বনিম্ন সীমার নিচে নেমে গেছে।',
                'url'       => null,
                'read_at'   => null,
                'created_at' => now()->subMinutes(30),
                'updated_at' => now()->subMinutes(30),
            ],
            [
                'tenant_id' => self::TENANT_ID,
                'user_id'   => null,
                'type'      => 'purchase',
                'title'     => 'নতুন ক্রয় যোগ হয়েছে',
                'message'   => 'একটি নতুন ক্রয় এন্ট্রি করা হয়েছে।',
                'url'       => null,
                'read_at'   => now()->subHour(),
                'created_at' => now()->subHours(2),
                'updated_at' => now()->subHour(),
            ],
            [
                'tenant_id' => self::TENANT_ID,
                'user_id'   => null,
                'type'      => 'due',
                'title'     => 'বকেয়া পরিশোধ হয়েছে',
                'message'   => 'একজন গ্রাহক তার বকেয়া পরিশোধ করেছেন।',
                'url'       => null,
                'read_at'   => null,
                'created_at' => now()->subHours(5),
                'updated_at' => now()->subHours(5),
            ],
            [
                'tenant_id' => self::TENANT_ID,
                'user_id'   => null,
                'type'      => 'expense',
                'title'     => 'নতুন খরচ যোগ হয়েছে',
                'message'   => 'আজকের একটি খরচ রেকর্ড করা হয়েছে।',
                'url'       => null,
                'read_at'   => now()->subHours(3),
                'created_at' => now()->subHours(8),
                'updated_at' => now()->subHours(3),
            ],
            [
                'tenant_id' => self::TENANT_ID,
                'user_id'   => null,
                'type'      => 'system',
                'title'     => 'মাসিক রিপোর্ট প্রস্তুত',
                'message'   => 'আপনার গত মাসের বিক্রয় রিপোর্ট প্রস্তুত হয়েছে।',
                'url'       => null,
                'read_at'   => null,
                'created_at' => now()->subDay(),
                'updated_at' => now()->subDay(),
            ],

            // ----- Personal notifications (tenant null => only user 4 sees them) -----
            [
                'tenant_id' => null,
                'user_id'   => self::USER_ID,
                'type'      => 'account',
                'title'     => 'স্বাগতম!',
                'message'   => 'হিসাব খাতায় আপনাকে স্বাগতম। আপনার অ্যাকাউন্ট প্রস্তুত।',
                'url'       => null,
                'read_at'   => null,
                'created_at' => now()->subMinutes(15),
                'updated_at' => now()->subMinutes(15),
            ],
            [
                'tenant_id' => null,
                'user_id'   => self::USER_ID,
                'type'      => 'security',
                'title'     => 'নতুন লগইন শনাক্ত হয়েছে',
                'message'   => 'একটি নতুন ডিভাইস থেকে আপনার অ্যাকাউন্টে লগইন হয়েছে।',
                'url'       => null,
                'read_at'   => null,
                'created_at' => now()->subHours(4),
                'updated_at' => now()->subHours(4),
            ],
            [
                'tenant_id' => null,
                'user_id'   => self::USER_ID,
                'type'      => 'profile',
                'title'     => 'প্রোফাইল আপডেট করুন',
                'message'   => 'আপনার প্রোফাইলের তথ্য সম্পূর্ণ করুন।',
                'url'       => null,
                'read_at'   => now()->subHours(6),
                'created_at' => now()->subHours(10),
                'updated_at' => now()->subHours(6),
            ],
            [
                'tenant_id' => null,
                'user_id'   => self::USER_ID,
                'type'      => 'system',
                'title'     => 'পাসওয়ার্ড পরিবর্তনের পরামর্শ',
                'message'   => 'নিরাপত্তার জন্য নিয়মিত আপনার পাসওয়ার্ড পরিবর্তন করুন।',
                'url'       => null,
                'read_at'   => null,
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
        ];
    }
}
