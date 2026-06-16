<?php

namespace App\Domains\Auth\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Handles the "forgot password" flow for every user (owner or employee):
 * request a reset link by email (delivered via Brevo) and set a new password
 * from the signed link.
 */
class PasswordResetController extends Controller
{
    /**
     * Show the "enter your email" form.
     */
    public function request(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Email a password reset link to the matching account.
     */
    public function email(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => t('valid.email_required'),
            'email.email'    => t('valid.email_invalid'),
        ]);

        Password::sendResetLink($request->only('email'));

        // Always report success to avoid leaking which emails are registered.
        return back()->with('status', t('authpage.reset_link_sent'));
    }

    /**
     * Show the "set a new password" form from the emailed link.
     */
    public function reset(Request $request, string $token): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    /**
     * Persist the new password.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'token'    => ['required'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'email.required'     => t('valid.email_required'),
            'email.email'        => t('valid.email_invalid'),
            'password.required'  => t('valid.password_required'),
            'password.min'       => t('valid.password_min'),
            'password.confirmed' => t('valid.password_confirmed'),
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password'       => $password,
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', t('authpage.reset_success'));
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => t('authpage.reset_failed')]);
    }
}
