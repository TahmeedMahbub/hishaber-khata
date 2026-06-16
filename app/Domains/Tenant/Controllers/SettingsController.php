<?php

namespace App\Domains\Tenant\Controllers;

use App\Domains\Auth\Notifications\EmployeeInvitationNotification;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        abort_unless($user->isOwner() && $user->tenant, 403);

        return view('contents.settings.index', [
            'user'      => $user,
            'tenant'    => $user->tenant,
            'settings'  => $user->tenant->settingsOrCreate(),
        ]);
    }

    public function employees(): View
    {
        $user = auth()->user();

        abort_unless($user->isOwner() && $user->tenant, 403);

        return view('contents.employees.index', [
            'user'      => $user,
            'tenant'    => $user->tenant,
            'employees' => $user->tenant->users()->where('id', '!=', $user->id)->orderBy('name')->get(),
        ]);
    }

    public function toggleEmployee(User $employee): RedirectResponse
    {
        $user = auth()->user();

        abort_unless($user->isOwner() && $user->tenant, 403);
        abort_unless($employee->tenant_id === $user->tenant_id && $employee->id !== $user->id, 403);

        $employee->update([
            'status' => $employee->status === 'active' ? 'inactive' : 'active',
        ]);

        return redirect()->route('employees.index')
            ->with('success', $employee->status === 'active' ? t('employee.activated') : t('employee.deactivated'));
    }

    public function resendInvite(User $employee): RedirectResponse
    {
        $user = auth()->user();

        abort_unless($user->isOwner() && $user->tenant, 403);
        abort_unless($employee->tenant_id === $user->tenant_id && $employee->id !== $user->id, 403);
        abort_unless(is_null($employee->email_verified_at), 403);

        $employee->notify(new EmployeeInvitationNotification($user));

        return redirect()->route('employees.index')
            ->with('success', t('msg.employee_invited'));
    }

    public function profile(): View
    {
        $user = auth()->user();

        return view('contents.profile.index', [
            'user'          => $user,
            'tenant'        => $user->tenant,
            'businessTypes' => config('business_types.types', []),
        ]);
    }

    public function switchLanguage(): RedirectResponse
    {
        $user = auth()->user();

        $user->update([
            'language' => $user->language === 'en' ? 'bn' : 'en',
        ]);

        return back();
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $rules = [
            'name'  => ['required', 'string', 'max:150'],
            'phone' => ['nullable', 'string', 'max:20', Rule::unique('users', 'phone')->ignore($user->id)],
            'email' => ['nullable', 'email', 'max:150', Rule::unique('users', 'email')->ignore($user->id)],
        ];

        $messages = [
            'name.required' => t('valid.name_required'),
            'phone.unique'  => t('valid.phone_in_use'),
            'email.unique'  => t('valid.email_in_use'),
        ];

        // Owners edit their business info in the same form.
        if ($user->isOwner() && $user->tenant) {
            $rules['business_name'] = ['required', 'string', 'max:150'];
            $rules['business_type'] = ['required', Rule::in(array_keys(config('business_types.types', [])))];
            $messages['business_name.required'] = t('valid.business_name_required');
        }

        $data = $request->validate($rules, $messages);

        $user->update([
            'name'  => $data['name'],
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
        ]);

        // For an owner, the personal name/phone/email are the source of truth
        // for the business's owner_name/phone/email — keep the tenant in sync,
        // and save the business name/type from the same form.
        if ($user->isOwner() && $user->tenant) {
            $user->tenant->update([
                'name'          => $data['business_name'],
                'business_type' => $data['business_type'],
                'owner_name'    => $data['name'],
                'phone'         => $data['phone'] ?? $user->tenant->phone,
                'email'         => $data['email'] ?? $user->tenant->email,
            ]);
        }

        return redirect()->route('profile')
            ->with('success', t('msg.profile_updated'));
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'current_password.required'     => t('valid.current_password_required'),
            'current_password.current_password' => t('valid.current_password_wrong'),
            'password.required'             => t('valid.password_required'),
            'password.min'                  => t('valid.password_min'),
            'password.confirmed'            => t('valid.password_confirmed'),
        ]);

        $validator->validateWithBag('password');

        $user->update(['password' => Hash::make($request->input('password'))]);

        return redirect()->route('profile')
            ->with('success', t('msg.password_changed'));
    }

    public function updatePreferences(Request $request): RedirectResponse
    {
        $user = auth()->user();

        abort_unless($user->isOwner() && $user->tenant, 403);

        $data = $request->validate([
            'currency'             => ['required', 'string', 'max:10'],
            'currency_symbol'      => ['required', 'string', 'max:10'],
            'date_format'          => ['required', 'string', 'max:20'],
            'invoice_prefix'       => ['nullable', 'string', 'max:20'],
            'track_stock'          => ['nullable', 'boolean'],
            'low_stock_alert'      => ['nullable', 'boolean'],
            'allow_negative_stock' => ['nullable', 'boolean'],
            'enable_barcode'       => ['nullable', 'boolean'],
            'show_profit'          => ['nullable', 'boolean'],
            'enable_due'           => ['nullable', 'boolean'],
        ]);

        $user->tenant->settingsOrCreate()->update([
            'currency'             => $data['currency'],
            'currency_symbol'      => $data['currency_symbol'],
            'date_format'          => $data['date_format'],
            'invoice_prefix'       => $data['invoice_prefix'] ?? 'INV-',
            'track_stock'          => $request->boolean('track_stock'),
            'low_stock_alert'      => $request->boolean('low_stock_alert'),
            'allow_negative_stock' => $request->boolean('allow_negative_stock'),
            'enable_barcode'       => $request->boolean('enable_barcode'),
            'show_profit'          => $request->boolean('show_profit'),
            'enable_due'           => $request->boolean('enable_due'),
        ]);

        return redirect()->route('settings.index')
            ->with('success', t('msg.settings_updated'));
    }

    public function storeEmployee(Request $request): RedirectResponse
    {
        $user = auth()->user();

        abort_unless($user->isOwner() && $user->tenant, 403);

        $validator = Validator::make($request->all(), [
            'name'     => ['required', 'string', 'max:150'],
            'phone'    => ['nullable', 'string', 'max:20', Rule::unique('users', 'phone')],
            'email'    => ['required', 'email', 'max:150', Rule::unique('users', 'email')],
            'role'     => ['required', Rule::in(['manager', 'staff'])],
        ], [
            'name.required'     => t('valid.employee_name_required'),
            'phone.unique'      => t('valid.phone_in_use'),
            'email.required'    => t('valid.employee_email_required'),
            'email.unique'      => t('valid.email_in_use'),
            'role.required'     => t('valid.role_required'),
        ]);

        $data = $validator->validateWithBag('employee');

        $employee = User::create([
            'tenant_id' => $user->tenant_id,
            'branch_id' => $user->branch_id,
            'name'      => $data['name'],
            'phone'     => $data['phone'] ?? null,
            'email'     => $data['email'],
            'password'  => Str::random(40),
            'role'      => $data['role'],
            'status'    => 'inactive',
        ]);

        // Invite the employee to verify their email and set their own password.
        $employee->notify(new EmployeeInvitationNotification($user));

        return redirect()->route('employees.index')
            ->with('success', t('msg.employee_invited'));
    }
}
