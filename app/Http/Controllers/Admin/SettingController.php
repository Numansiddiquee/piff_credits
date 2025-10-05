<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\Setting;

class SettingController extends Controller
{
    public function view()
    {
        $action = 'view';
        return view('admin.setting.overview')->with(compact( 'action'));;
    }

    public function setting()
    {
        $user = auth()->user();
        $action = 'setting';
        return view('admin.setting.overview')->with(compact('user', 'action'));
    }

    public function update(Request $request)
    {

        $user = auth()->user();

        $user->name = $request->fname . ' ' . $request->lname;
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->phone = $request->phone;
        $user->company_name = $request->company;
        $user->save();

        if ($user->company) {
            $user->company->update([
                'name' =>  $request->company,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'zip_code' => $request->zip,
            ]);

        } else {
            $company = Company::create([
                'name' => $request->company,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'zip_code' => $request->zip,
            ]);

            $user->company_id = $company->id;
        }

        if ($request->hasFile('avatar')) {

            $file = $request->file('avatar');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('images', $filename, 'public');
            $user->avatar = $path;
            $user->save();
        }

        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('logos', $filename, 'public');

            if ($user->company) {
                $user->company->logo = $path;
                $user->company->save();
            }
        }

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function security()
    {
        $user = auth()->user();
        $action = 'security';
        return view('admin.setting.overview')->with(compact('user', 'action'));
    }

    public function platformSetting()
    {
        $user = auth()->user();
        $action = 'general';
        return view('admin.setting.overview')->with(compact('user', 'action'));
    }

    public function platformSettingUpdate(Request $request)
    {
        $validated = $request->validate([
            'platform_name' => 'required|string|max:255',
            'platform_logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'platform_favicon' => 'nullable|image|mimes:png,jpg,jpeg,ico|max:2048',
            'support_email' => 'required|email|max:255',
            'support_contact_info' => 'nullable|string|max:255',
            'default_language' => 'required|string|in:en,es,fr', // Adjust allowed values
            'default_timezone' => 'required|string', // Validate against timezone_identifiers_list()
            'maintenance_mode' => 'nullable|in:0,1',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'default_currency' => 'required|string|in:USD,AED,PKR', // Adjust allowed values
            'minimum_withdrawal_amount' => 'required|numeric|min:0',
            'withdrawal_processing_time' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('platform_logo')) {
            $path = $request->file('platform_logo')->store('logos', 'public');
            Setting::set('platform_logo', $path);
        } elseif ($request->input('platform_logo_remove')) {
            Setting::set('platform_logo', null);
        }

        if ($request->hasFile('platform_favicon')) {
            $path = $request->file('platform_favicon')->store('favicons', 'public');
            Setting::set('platform_favicon', $path);
        } elseif ($request->input('platform_favicon_remove')) {
            Setting::set('platform_favicon', null);
        }

        Setting::set('platform_name', $validated['platform_name']);
        Setting::set('support_email', $validated['support_email']);
        Setting::set('support_contact_info', $validated['support_contact_info']);
        Setting::set('default_language', $validated['default_language']);
        Setting::set('default_timezone', $validated['default_timezone']);
        Setting::set('maintenance_mode', $request->has('maintenance_mode') ? '1' : '0');
        Setting::set('commission_rate', $validated['commission_rate']);
        Setting::set('default_currency', $validated['default_currency']);
        Setting::set('minimum_withdrawal_amount', $validated['minimum_withdrawal_amount']);
        Setting::set('withdrawal_processing_time', $validated['withdrawal_processing_time']);

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'currentpassword' => 'required',
            'newpassword' => 'required|min:8|same:confirmpassword',
        ], [
            'currentpassword.required' => 'Please enter your current password.',
            'newpassword.required' => 'Please enter a new password.',
            'newpassword.min' => 'The new password must be at least 8 characters.',
            'newpassword.same' => 'The new password confirmation does not match.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->currentpassword, $user->password)) {
            return back()->withErrors(['currentpassword' => 'Your current password is incorrect.']);
        }

        $user->password = Hash::make($request->newpassword);
        $user->save();

        return back()->with('success', 'Password updated successfully.');
    }

    public function paymentMethod()
    {
        $user = auth()->user();
        $action = 'payment';
        return view('admin.setting.overview')->with(compact('user', 'action'));
    }

    public function StoreCredentials(Request $request)
    {
        $request->validate([
            'provider' => 'required|string',
            'mode' => 'required|in:sandbox,live',
            'public_key' => 'nullable|string',
            'secret_key' => 'nullable|string',
            'additional_key' => 'nullable|string',
        ]);

        PaymentMethod::updateOrCreate(
            [
                'company_id' => Auth::user()->company_id,
                'provider' => $request->provider,
            ],
            [
                'mode' => $request->mode,
                'public_key' => $request->public_key,
                'secret_key' => $request->secret_key,
                'additional_key' => $request->additional_key,
                'status' => 'Active',
            ]
        );

        return redirect()->back()->with('success', 'Payment credentials saved successfully.');
    }
}
