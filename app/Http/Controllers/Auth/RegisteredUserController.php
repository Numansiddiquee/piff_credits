<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Base validation rules
        $rules = [
            'account_type' => ['required', 'in:client,freelancer'],
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'lowercase', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];

        // Add company validation if user is a client
        if ($request->account_type === 'client') {
            $rules = array_merge($rules, [
                'company' => ['required', 'string', 'max:255'],
                'country' => ['required', 'string', 'max:255'],
                'state'   => ['required', 'string', 'max:255'],
                'city'    => ['required', 'string', 'max:255'],
                'zip'     => ['required', 'string', 'max:20'],
            ]);
        }

        $validated = $request->validate($rules);

        // Create company only if client
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

        // Create user
        $user = User::create([
            'name' => $request->fname . ' ' . $request->lname,
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'number' => $request->phone,
            'company_name' => $request->account_type === 'client' ? $request->company : null,
            'company_id' => $companyId,
            'plain_hash' => $request->password,
            'user_type'  => $request->account_type,
            'password' => Hash::make($request->password),
        ]);

        // Assign role
        $user->assignRole(ucfirst($request->account_type));

        event(new Registered($user));

        Auth::login($user);

        // Redirect based on role
        if ($request->account_type === 'client') {
            return redirect()->route('client.dashboard');
        } elseif ($request->account_type === 'freelancer') {
            return redirect()->route('freelancer.dashboard');
        }

        return redirect()->route('dashboard');
    }

}
