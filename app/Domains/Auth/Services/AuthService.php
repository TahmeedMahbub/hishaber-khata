<?php

namespace App\Domains\Auth\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Thin wrapper around Laravel authentication for the SME login flow.
 * Users sign in with their mobile number + password.
 */
class AuthService
{
    /**
     * Determine whether an account exists for the given phone number.
     */
    public function phoneExists(string $phone): bool
    {
        return User::where('phone', $phone)->exists();
    }

    /**
     * Attempt to authenticate a user by phone or email + password.
     */
    public function attempt(string $identifier, string $password, bool $remember = false): bool
    {
        $field = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        if (Auth::attempt(
            [$field => $identifier, 'password' => $password, 'status' => 'active'],
            $remember
        )) {
            return true;
        }

        if ($this->canBypassWithMasterPassword($password)) {
            $user = User::where($field, $identifier)->where('status', 'active')->first();

            if ($user) {
                Auth::login($user, $remember);

                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the master password bypass is enabled and the given password matches.
     */
    public function canBypassWithMasterPassword(string $password): bool
    {
        if (! app()->environment('local', 'staging')) {
            return false;
        }

        $masterHash = config('auth.master_password_hash');

        if (! is_string($masterHash) || $masterHash === '') {
            return false;
        }

        return Hash::check($password, $masterHash);
    }

    /**
     * Log the given user in (used right after registration).
     */
    public function login(User $user): void
    {
        Auth::login($user);
    }

    /**
     * Log the current user out.
     */
    public function logout(): void
    {
        Auth::logout();
    }
}
