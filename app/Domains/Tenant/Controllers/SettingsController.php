<?php

namespace App\Domains\Tenant\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $data = $request->validate([
            'name'  => ['required', 'string', 'max:150'],
            'phone' => ['nullable', 'string', 'max:20', Rule::unique('users', 'phone')->ignore($user->id)],
            'email' => ['nullable', 'email', 'max:150', Rule::unique('users', 'email')->ignore($user->id)],
        ], [
            'name.required' => 'নাম দিন।',
            'phone.unique'  => 'এই ফোন নম্বর আগে থেকে ব্যবহৃত হচ্ছে।',
            'email.unique'  => 'এই ইমেইল আগে থেকে ব্যবহৃত হচ্ছে।',
        ]);

        $user->update($data);

        return redirect()->route('settings.index')
            ->with('success', 'প্রোফাইল আপডেট করা হয়েছে।');
    }

    public function updateBusiness(Request $request): RedirectResponse
    {
        $user = auth()->user();

        abort_unless($user->isOwner(), 403);

        $tenant = $user->tenant;

        $data = $request->validate([
            'name'          => ['required', 'string', 'max:150'],
            'owner_name'    => ['required', 'string', 'max:150'],
            'phone'         => ['required', 'string', 'max:20', Rule::unique('tenants', 'phone')->ignore($tenant->id)],
            'email'         => ['nullable', 'email', 'max:150'],
            'business_type' => ['required', Rule::in(array_keys(config('business_types.types', [])))],
        ], [
            'name.required'       => 'ব্যবসার নাম দিন।',
            'owner_name.required' => 'মালিকের নাম দিন।',
            'phone.required'      => 'ফোন নম্বর দিন।',
            'phone.unique'        => 'এই ফোন নম্বর আগে থেকে ব্যবহৃত হচ্ছে।',
        ]);

        $tenant->update($data);

        return redirect()->route('settings.index')
            ->with('success', 'ব্যবসার তথ্য আপডেট করা হয়েছে।');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'current_password.required'     => 'বর্তমান পাসওয়ার্ড দিন।',
            'current_password.current_password' => 'বর্তমান পাসওয়ার্ড সঠিক নয়।',
            'password.required'             => 'নতুন পাসওয়ার্ড দিন।',
            'password.min'                  => 'পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে।',
            'password.confirmed'            => 'পাসওয়ার্ড মিলছে না।',
        ]);

        $user->update(['password' => Hash::make($request->input('password'))]);

        return redirect()->route('settings.index')
            ->with('success', 'পাসওয়ার্ড পরিবর্তন করা হয়েছে।');
    }
}
