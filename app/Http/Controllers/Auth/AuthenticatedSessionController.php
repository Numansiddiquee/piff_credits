<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use App\Models\TwoFactorCode;
use App\Mail\TwoFactorCodeMail;
use Carbon\Carbon;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();


        $request->session()->forget(['2fa_passed', '2fa_pending']);
        TwoFactorCode::where('user_id', $user->id)->delete();

        $code = rand(100000, 999999);
        TwoFactorCode::create([
            'user_id'    => $user->id,
            'code'       => $code,
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);

        Mail::to($user->email)->send(new TwoFactorCodeMail($code));

        // Store intended route in session based on role
        if ($user->hasRole('Super Admin')) {
            session(['2fa.intended' => route('admin.dashboard')]);
        } elseif ($user->hasRole('Client')) {
            session(['2fa.intended' => route('client.dashboard')]);
        } elseif ($user->hasRole('Freelancer')) {
            session(['2fa.intended' => route('freelancer.dashboard')]);
        } else {
            session(['2fa.intended' => route('dashboard')]);
        }

        session(['2fa_pending' => true]);

        return redirect()->route('verify.2fa');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        // clear 2FA session
        $request->session()->forget(['2fa_passed','2fa.intended']);
        
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

}
