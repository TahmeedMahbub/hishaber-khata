<?php

namespace App\Domains\Auth\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VerifyEmailController extends Controller
{
    /**
     * Show the "please verify your email" notice.
     */
    public function notice(Request $request): RedirectResponse|View
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        return view('auth.verify-email');
    }

    /**
     * Handle the signed verification link from the Brevo email.
     */
    public function verify(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard')->with('status', 'verified');
        }

        $request->fulfill();

        return redirect()->route('dashboard')->with('status', 'verified');
    }

    /**
     * Verify the email using the 4-digit code entered by the user.
     */
    public function verifyCode(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard')->with('status', 'verified');
        }

        $validated = $request->validate([
            'code' => ['required', 'digits:4'],
        ]);

        $user = $request->user();

        if (! $user->isValidVerificationCode($validated['code'])) {
            $user->increment('email_verification_attempts');

            // After 5 wrong attempts, invalidate the current code and email a fresh one.
            if ($user->email_verification_attempts >= 5) {
                $user->sendEmailVerificationNotification();

                return back()->with('status', 'verification-link-sent')->withErrors([
                    'code' => t('authpage.verify_code_max_attempts'),
                ]);
            }

            $remaining = 5 - $user->email_verification_attempts;

            return back()->withErrors([
                'code' => t('authpage.verify_code_invalid').' ('.$remaining.' '.t('authpage.verify_code_attempts_left').')',
            ]);
        }

        $user->markEmailAsVerified();
        $user->forceFill([
            'email_verification_code' => null,
            'email_verification_code_expires_at' => null,
            'email_verification_attempts' => 0,
        ])->save();

        return redirect()->route('dashboard')->with('status', 'verified');
    }

    /**
     * Resend the verification email via Brevo.
     */
    public function resend(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
