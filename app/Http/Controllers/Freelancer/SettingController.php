<?php

namespace App\Http\Controllers\Freelancer;

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
        return view('freelancer.setting.overview')->with(compact( 'action'));;
    }

    public function setting()
    {
        $user = auth()->user();
        $action = 'setting';
        return view('freelancer.setting.overview')->with(compact('user', 'action'));
    }

    public function update(Request $request)
    {

        $user = auth()->user();

        $user->name = $request->fname . ' ' . $request->lname;
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->phone = $request->phone;
        $user->save();

        
        if ($request->hasFile('avatar')) {

            $file = $request->file('avatar');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('images', $filename, 'public');
            $user->avatar = $path;
            $user->save();
        }

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function security()
    {
        $user = auth()->user();
        $action = 'security';
        return view('freelancer.setting.overview')->with(compact('user', 'action'));
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
        return view('freelancer.setting.overview')->with(compact('user', 'action'));
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
