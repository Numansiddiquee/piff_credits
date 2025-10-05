<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TwoFactorCode;
use Carbon\Carbon;

class TwoFactorController extends Controller
{
    public function index()
    {
        return view('auth.verify-2fa');
    }

    public function store(Request $request)
    {
        $request->validate(['two_factor_code' => 'required|numeric']);

        $record = TwoFactorCode::where('user_id', Auth::id())
            ->where('code', $request->two_factor_code)
            ->first();

        if (!$record) {
            return back()->withErrors(['two_factor_code' => 'Invalid code.']);
        }

        if (Carbon::now()->gt($record->expires_at)) {
            $record->delete();
            return back()->withErrors(['two_factor_code' => 'Code expired.']);
        }

        $record->delete();

        session(['2fa_passed' => true]);

        return redirect()->to(session()->pull('2fa.intended', route('dashboard')));
    }

    public function resend(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Delete old code
        TwoFactorCode::where('user_id', $user->id)->delete();

        // Create new code
        $code = rand(100000, 999999);
        TwoFactorCode::create([
            'user_id'    => $user->id,
            'code'       => $code,
            'expires_at' => now()->addMinutes(10),
        ]);

        // Send new code via email
        \Mail::to($user->email)->send(new \App\Mail\TwoFactorCodeMail($code));

        return back()->with('status', 'A new verification code has been sent to your email.');
    }
}