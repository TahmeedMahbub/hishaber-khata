<?php

namespace App\Domains\Auth\Controllers;

use App\Domains\Auth\Requests\LoginRequest;
use App\Domains\Auth\Services\AuthService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function __construct(protected AuthService $auth)
    {
    }

    /**
     * Show the login form.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle a login request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        // if (! $this->auth->phoneExists($credentials['phone'])) {
        //     return back()
        //         ->withInput($request->only('phone'))
        //         ->with('show_register_prompt', true)
        //         ->withErrors(['phone' => 'এই মোবাইল নম্বরে কোনো অ্যাকাউন্ট নেই। প্রথমে রেজিস্টার করুন।']);
        // }

        if (! $this->auth->attempt($credentials['phone'], $credentials['password'], $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('phone'))
                ->with('show_register_prompt', true)
                ->withErrors(['phone' => t('msg.no_account')]);
        }

        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }

    /**
     * Log the user out.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $this->auth->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
