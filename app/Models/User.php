<?php

namespace App\Models;

use App\Domains\Auth\Notifications\EmailVerificationCodeNotification;
use App\Domains\Common\Traits\HasPublicId;
use App\Domains\Tenant\Models\Branch;
use App\Domains\Tenant\Models\Tenant;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, HasPublicId, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tenant_id',
        'branch_id',
        'name',
        'phone',
        'email',
        'password',
        'role',
        'status',
        'language',
        'email_verification_code',
        'email_verification_code_expires_at',
        'email_verification_attempts',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'email_verification_code_expires_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }

    /**
     * Generate a fresh 4-digit code and email it to the user.
     *
     * Overrides the default link-based verification so both registration and
     * "resend" flows deliver a 4-digit code instead.
     */
    public function sendEmailVerificationNotification(): void
    {
        $code = str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);

        $this->forceFill([
            'email_verification_code' => $code,
            'email_verification_code_expires_at' => Carbon::now()->addMinutes(15),
            'email_verification_attempts' => 0,
        ])->save();

        $this->notify(new EmailVerificationCodeNotification($code));
    }

    /**
     * Check whether the given code matches and has not expired.
     */
    public function isValidVerificationCode(string $code): bool
    {
        if (empty($this->email_verification_code) || $this->email_verification_code_expires_at === null) {
            return false;
        }

        if ($this->email_verification_code_expires_at->isPast()) {
            return false;
        }

        return hash_equals($this->email_verification_code, $code);
    }
}
