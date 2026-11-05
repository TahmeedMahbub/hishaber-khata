<?php

namespace App\Domains\Auth\Controllers;

use App\Domains\Auth\Models\GoogleRegistration;
use App\Domains\Auth\Services\AuthService;
use App\Domains\Auth\Services\BusinessRegistrationService;
use App\Http\Controllers\Controller;
use App\Http\Middleware\CaptureAttribution;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

/**
 * Google OAuth login & registration.
 *
 * - Account already linked to this Google ID: logged in.
 * - Existing email/password account with the same email: must confirm its password
 *   once before Google is linked. Never moved to another tenant; password untouched.
 * - Unknown email: the verified identity is stored in google_registrations (resumable),
 *   then the business form creates tenant + owner via BusinessRegistrationService.
 */
class GoogleAuthController extends Controller
{
    protected const SESSION_KEY = 'google_signup';
    protected const LINK_KEY = 'google_link';

    public function __construct(
        protected AuthService $auth,
        protected BusinessRegistrationService $registration,
    ) {
    }

    /**
     * Send the visitor to Google. Socialite stores and later validates the OAuth state.
     */
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google's callback.
     */
    public function callback(Request $request): RedirectResponse
    {
        if ($request->filled('error') || ! $request->filled('code')) {
            return $this->fail($request->filled('error') ? 'authpage.google_cancelled' : 'authpage.google_failed');
        }

        try {
            $google = Socialite::driver('google')->user();
        } catch (Throwable $e) {
            // Invalid/missing state, expired code, network errors. Log class only: never tokens/secrets.
            Log::warning('Google OAuth callback failed', ['exception' => get_class($e)]);

            return $this->fail('authpage.google_failed');
        }

        $googleId = (string) $google->getId();
        $email = Str::lower(trim((string) $google->getEmail()));
        $raw = (array) ($google->user ?? []);
        $verified = filter_var($raw['email_verified'] ?? $raw['verified_email'] ?? false, FILTER_VALIDATE_BOOLEAN);

        if ($googleId === '' || $email === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL) || ! $verified) {
            return $this->fail('authpage.google_no_email');
        }

        $linked = User::where('google_id', $googleId)->first();

        if ($linked !== null) {
            return $this->loginLinked($request, $linked);
        }

        $byEmail = User::whereRaw('LOWER(email) = ?', [$email])->first();

        if ($byEmail !== null) {
            if ($byEmail->google_id !== null) {
                return $this->fail('authpage.google_conflict');
            }

            if ($byEmail->status !== 'active') {
                return $this->fail('authpage.google_inactive');
            }

            // Existing email/password account: never link silently. Require its password.
            $request->session()->put(self::LINK_KEY, ['user_id' => $byEmail->id, 'google_id' => $googleId]);

            return redirect()->route('auth.google.link');
        }

        // Persist the verified identity so an abandoned signup can be resumed later.
        GoogleRegistration::updateOrCreate(['google_id' => $googleId], [
            'email' => $email,
            'name' => (string) ($google->getName() ?: Str::before($email, '@')),
            'expires_at' => now()->addDays(GoogleRegistration::TTL_DAYS),
        ]);
        $request->session()->put(self::SESSION_KEY, $googleId);

        return redirect()->route('auth.google.complete');
    }

    public function linkForm(Request $request): View|RedirectResponse
    {
        $user = $this->pendingLinkUser($request);

        if ($user === null) {
            return $this->fail('authpage.google_session_expired');
        }

        return view('auth.google-link', ['email' => $user->email]);
    }

    public function linkStore(Request $request): RedirectResponse
    {
        $user = $this->pendingLinkUser($request);

        if ($user === null) {
            return $this->fail('authpage.google_session_expired');
        }

        $request->validate(['password' => ['required', 'string']]);

        if (! Hash::check($request->input('password'), $user->password)) {
            return back()->withErrors(['password' => t('authpage.google_link_bad_password')]);
        }

        $googleId = $request->session()->get(self::LINK_KEY)['google_id'];

        // Password proves ownership; Google proved the email. Password is left unchanged.
        $user->forceFill(['google_id' => $googleId])->save();
        $request->session()->forget(self::LINK_KEY);

        return $this->loginLinked($request, $user);
    }

    /**
     * Onboarding form for first-time Google users.
     */
    public function completeForm(Request $request): View|RedirectResponse
    {
        $pending = $this->pendingRegistration($request);

        if ($pending === null) {
            return $this->fail('authpage.google_session_expired');
        }

        $first = Str::before(trim($pending->name ?: Str::before($pending->email, '@')), ' ');

        return view('auth.google-complete', [
            'google' => ['email' => $pending->email, 'name' => $pending->name],
            'defaultBusinessName' => $first . "'s Business",
            'businessTypes' => config('business_types.types'),
        ]);
    }

    /**
     * Create the tenant + owner for a first-time Google user.
     */
    public function completeStore(Request $request): RedirectResponse
    {
        $pending = $this->pendingRegistration($request);

        if ($pending === null) {
            return $this->fail('authpage.google_session_expired');
        }

        // Email may have been registered meanwhile: never create a duplicate.
        if (User::whereRaw('LOWER(email) = ?', [$pending->email])->orWhere('google_id', $pending->google_id)->exists()) {
            $pending->delete();
            $request->session()->forget(self::SESSION_KEY);

            return $this->fail('authpage.google_failed');
        }

        $data = $request->validate([
            'business_name' => ['required', 'string', 'max:150'],
            'owner_name' => ['required', 'string', 'max:150'],
            'phone' => ['required', 'string', 'max:20', 'unique:tenants,phone', 'unique:users,phone'],
            'business_type' => ['required', 'string', Rule::in(array_keys(config('business_types.types')))],
        ], [
            'phone.unique' => t('valid.register_phone_unique'),
        ]);

        $user = DB::transaction(function () use ($data, $pending, $request) {
            $user = $this->registration->register($data + [
                'email' => $pending->email,
                // Never used: Google handles login. Random so the column is never guessable.
                'password' => Str::random(40),
            ]);

            $user->forceFill([
                'google_id' => $pending->google_id,
                'email_verified_at' => now(),
                'last_ip' => $request->ip(),
            ])->save();

            $pending->delete();

            return $user;
        });

        $request->session()->forget(self::SESSION_KEY);

        $this->auth->login($user);
        CaptureAttribution::attachUser($request, $user->id);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    protected function pendingRegistration(Request $request): ?GoogleRegistration
    {
        $googleId = $request->session()->get(self::SESSION_KEY);

        if (! is_string($googleId)) {
            return null;
        }

        $pending = GoogleRegistration::where('google_id', $googleId)->first();

        return ($pending && ! $pending->isExpired()) ? $pending : null;
    }

    protected function pendingLinkUser(Request $request): ?User
    {
        $link = $request->session()->get(self::LINK_KEY);

        if (! is_array($link)) {
            return null;
        }

        $user = User::find($link['user_id']);

        return ($user && $user->google_id === null && $user->status === 'active') ? $user : null;
    }

    protected function loginLinked(Request $request, User $user): RedirectResponse
    {
        if ($user->status !== 'active') {
            return $this->fail('authpage.google_inactive');
        }

        $user->forceFill([
            'email_verified_at' => $user->email_verified_at ?? now(),
            'last_ip' => $request->ip(),
        ])->save();

        $this->auth->login($user);
        CaptureAttribution::attachUser($request, $user->id);
        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }

    protected function fail(string $translationKey): RedirectResponse
    {
        return redirect()->route('login')->withErrors(['google' => t($translationKey)]);
    }
}
