<?php

namespace App\Domains\Auth\Controllers;

use App\Domains\Auth\Requests\RegisterBusinessRequest;
use App\Domains\Auth\Services\AuthService;
use App\Domains\Auth\Services\BusinessRegistrationService;
use App\Http\Controllers\Controller;
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

        $this->auth->login($user);

        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }
}
