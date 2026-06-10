<?php

namespace App\Domains\Tenant\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): RedirectResponse
    {
        return redirect()->route('profile');
    }

    public function profile(): View
    {
        $user = auth()->user();

        return view('contents.profile.index', [
            'user'          => $user,
            'tenant'        => $user->tenant,
            'businessTypes' => config('business_types.types', []),
            'employees'     => $user->isOwner() && $user->tenant
                ? $user->tenant->users()->where('id', '!=', $user->id)->orderBy('name')->get()
                : collect(),
        ]);
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
            'name.required' => 'নাম দিন।',
            'phone.unique'  => 'এই ফোন নম্বর আগে থেকে ব্যবহৃত হচ্ছে।',
            'email.unique'  => 'এই ইমেইল আগে থেকে ব্যবহৃত হচ্ছে।',
        ];

        // Owners edit their business info in the same form.
        if ($user->isOwner() && $user->tenant) {
            $rules['business_name'] = ['required', 'string', 'max:150'];
            $rules['business_type'] = ['required', Rule::in(array_keys(config('business_types.types', [])))];
            $messages['business_name.required'] = 'ব্যবসার নাম দিন।';
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

        return redirect()->route('settings.index')
            ->with('success', 'প্রোফাইল আপডেট করা হয়েছে।');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'current_password.required'     => 'বর্তমান পাসওয়ার্ড দিন।',
            'current_password.current_password' => 'বর্তমান পাসওয়ার্ড সঠিক নয়।',
            'password.required'             => 'নতুন পাসওয়ার্ড দিন।',
            'password.min'                  => 'পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে।',
            'password.confirmed'            => 'পাসওয়ার্ড মিলছে না।',
        ]);

        $validator->validateWithBag('password');

        $user->update(['password' => Hash::make($request->input('password'))]);

        return redirect()->route('settings.index')
            ->with('success', 'পাসওয়ার্ড পরিবর্তন করা হয়েছে।');
    }

    public function storeEmployee(Request $request): RedirectResponse
    {
        $user = auth()->user();

        abort_unless($user->isOwner() && $user->tenant, 403);

        $validator = Validator::make($request->all(), [
            'name'     => ['required', 'string', 'max:150'],
            'phone'    => ['nullable', 'string', 'max:20', Rule::unique('users', 'phone')],
            'email'    => ['nullable', 'email', 'max:150', Rule::unique('users', 'email')],
            'role'     => ['required', Rule::in(['manager', 'staff'])],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required'     => 'কর্মচারীর নাম দিন।',
            'phone.unique'      => 'এই ফোন নম্বর আগে থেকে ব্যবহৃত হচ্ছে।',
            'email.unique'      => 'এই ইমেইল আগে থেকে ব্যবহৃত হচ্ছে।',
            'role.required'     => 'ভূমিকা নির্বাচন করুন।',
            'password.required' => 'পাসওয়ার্ড দিন।',
            'password.min'      => 'পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে।',
            'password.confirmed' => 'পাসওয়ার্ড মিলছে না।',
        ]);

        $data = $validator->validateWithBag('employee');

        User::create([
            'tenant_id' => $user->tenant_id,
            'branch_id' => $user->branch_id,
            'name'      => $data['name'],
            'phone'     => $data['phone'] ?? null,
            'email'     => $data['email'] ?? null,
            'password'  => $data['password'],
            'role'      => $data['role'],
            'status'    => 'active',
        ]);

        return redirect()->route('settings.index')
            ->with('success', 'নতুন কর্মচারী যোগ করা হয়েছে।');
    }
}
