<?php

namespace App\Domains\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

/**
 * Handles the invited-employee onboarding link: the employee verifies their
 * email by opening the signed link and then chooses their own password.
 */
class EmployeeSetupController extends Controller
{
    /**
     * Show the "set your password" form for an invited employee.
     */
    public function show(Request $request, int $id, string $hash): View|RedirectResponse
    {
        $user = User::findOrFail($id);

        $this->ensureValidHash($user, $hash);

        // Link already used (email verified + password set).
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')->with('status', 'invite-already-used');
        }

        $actionUrl = URL::temporarySignedRoute(
            'employee.setup.store',
            Carbon::now()->addHour(),
            ['id' => $user->getKey(), 'hash' => $hash],
        );

        return view('auth.employee-setup', [
            'employee'  => $user,
            'actionUrl' => $actionUrl,
        ]);
    }

    /**
     * Store the chosen password, verify the email, activate and log in.
     */
    public function store(Request $request, int $id, string $hash): RedirectResponse
    {
        $user = User::findOrFail($id);

        $this->ensureValidHash($user, $hash);

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')->with('status', 'invite-already-used');
        }

        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'password.required'  => t('valid.password_required'),
            'password.min'       => t('valid.password_min'),
            'password.confirmed' => t('valid.password_confirmed'),
        ]);

        $validator->validate();

        $user->forceFill([
            'password'          => $request->input('password'),
            'email_verified_at' => now(),
            'status'            => 'active',
        ])->save();

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    /**
     * Abort unless the URL hash matches the employee's email.
     */
    protected function ensureValidHash(User $user, string $hash): void
    {
        if (! hash_equals(sha1($user->getEmailForVerification()), $hash)) {
            abort(403);
        }
    }
}
