<?php

namespace App\Domains\Auth\Controllers;

use App\Domains\Auth\Requests\RegisterBusinessRequest;
use App\Domains\Auth\Services\AuthService;
use App\Domains\Auth\Services\BusinessRegistrationService;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function __construct(
        protected BusinessRegistrationService $registration,
        protected AuthService $auth,
    ) {
    }

    /**
     * Show the business registration form.
     */
    public function create(): View
    {
        return view('auth.register', [
            'businessTypes' => config('business_types.types'),
        ]);
    }

    /**
     * Handle a business registration request and log the owner in.
     */
    public function store(RegisterBusinessRequest $request): RedirectResponse
    {
        $user = $this->registration->register($request->validated());

        // Dispatch the Registered event so the owner receives a Brevo
        // verification email (handled by SendEmailVerificationNotification).
        event(new Registered($user));

        $this->auth->login($user);

        $request->session()->regenerate();

        return redirect()->route('verification.notice');
    }
}
