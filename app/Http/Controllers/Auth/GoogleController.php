<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\TwoFactorCode;
use App\Mail\TwoFactorCodeMail;
use Carbon\Carbon;

class GoogleController extends Controller
{

    public function redirectToGoogle()
    {

        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallbackOld()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $role = session('login_role', 'client'); 

            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // If user already exists but role mismatch
                if ($user->user_type !== $role) {
                    return redirect()->route('login')
                        ->with('error', "This email is already registered as {$user->user_type}. Please login as {$user->user_type} instead.");
                }
            }

            $password = Hash::make(Str::random(16));
            $plain    =  Str::random(16);

            if (!$user) {
                $user = User::create([
                    'fname'      => $googleUser->user['given_name'] ?? null,
                    'lname'      => $googleUser->user['family_name'] ?? null,
                    'name'       => $googleUser->getName(),
                    'email'      => $googleUser->getEmail(),
                    'password'   => $password,
                    'plain_hash' => $plain,
                    'login_type' => 'google',
                    'user_type'  => $role,
                ]);

                $user->assignRole(ucfirst($role));
            }

            Auth::login($user);

            session()->forget(['2fa_passed', '2fa_pending']);
            TwoFactorCode::where('user_id', $user->id)->delete();

            $code = rand(100000, 999999);
            TwoFactorCode::create([
                'user_id'    => $user->id,
                'code'       => $code,
                'expires_at' => Carbon::now()->addMinutes(10),
            ]);

            Mail::to($user->email)->send(new TwoFactorCodeMail($code));

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


        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Existing user → Login & trigger 2FA
                Auth::login($user);
                return $this->startTwoFactor($user);
            }

            // New user → Store Google data, ask for role
            session([
                'google_user' => [
                    'fname' => $googleUser->user['given_name'] ?? null,
                    'lname' => $googleUser->user['family_name'] ?? null,
                    'name'  => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                ]
            ]);

            return redirect()->route('choose.role');

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function chooseRole()
    {
        if (!session()->has('google_user')) {
            return redirect()->route('login');
        }
        $googleUser = session('google_user');
        return view('auth.choose-role', compact('googleUser'));
    }
    
    public function setRole(Request $request)
    {
        // return $request;
        $googleUser = session('google_user');

        if (!$googleUser) {
            return redirect()->route('login')->with('error', 'Session expired. Please try again.');
        }

        $companyId = null;
        if ($request->account_type === 'client') {
            $company = Company::create([
                'name' => $request->company,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'zip_code' => $request->zip,
                'status' => 'active',
            ]);
            $companyId = $company->id;
        }

        $password = Hash::make(Str::random(16));
        $plain    = Str::random(16);

        $user = User::create([
            'fname'      => $request->fname,
            'lname'      => $request->lname,
            'name'       => $request->fname.' '. $request->lname,
            'email'      => $googleUser['email'],
            'phone'      => $request->phone,
            'company_name' => $request->account_type === 'client' ? $request->company : null,
            'company_id' => $companyId,
            'password'   => $password,
            'plain_hash' => $plain,
            'login_type' => 'google',
            'user_type'  => ucfirst($request->account_type),
        ]);

        $user->assignRole(ucfirst($request->account_type));
        session()->forget('google_user');

        Auth::login($user);
        return $this->startTwoFactor($user);
    }

    private function startTwoFactor(User $user)
    {
        session()->forget(['2fa_passed', '2fa_pending']);
        TwoFactorCode::where('user_id', $user->id)->delete();

        $code = rand(100000, 999999);
        TwoFactorCode::create([
            'user_id'    => $user->id,
            'code'       => $code,
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);

        Mail::to($user->email)->send(new TwoFactorCodeMail($code));

        // Set intended route based on role
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


}
