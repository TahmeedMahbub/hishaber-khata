<?php

namespace App\Domains\Auth\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
     * Attempt to authenticate a user by phone + password.
     */
    public function attempt(string $phone, string $password, bool $remember = false): bool
    {
        return Auth::attempt(
            ['phone' => $phone, 'password' => $password, 'status' => 'active'],
            $remember
        );
    }

    /**
     * Log the given user in (used right after registration).
     */
    public function login(\App\Models\User $user): void
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
