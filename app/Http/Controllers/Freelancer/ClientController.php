<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\ClientCreatedMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Company;    
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash; 

class ClientController extends Controller
{
    public function createClient()
    {
        return view('freelancer.client.create');
    }

    public function storeClient(Request $request)
    {
        // return $request;
        $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'role'          => 'required|in:Client,Freelancer,Super Admin', // Adjust roles if needed
            'image'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'company_logo'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'company'       => 'nullable|string|max:255',
            'country'       => 'nullable|string|max:100',
            'state'         => 'nullable|string|max:100',
            'city'          => 'nullable|string|max:100',
            'zip'           => 'nullable|string|max:20',
        ]);

        $temporaryPassword  = Str::random(10);

        $user               = new User();
        $user->fname        = $request->first_name;
        $user->lname        = $request->last_name;
        $user->name         = $request->first_name . ' ' . $request->last_name;
        $user->email        = $request->email;
        $user->phone        = $request->phone_number;
        $user->company_name = $request->company ?? null;
        $user->password     = Hash::make($temporaryPassword);
        $user->plain_hash   = $temporaryPassword;
        $user->user_type    = lcfirst($request->role);
        $user->login_type   = 'email';

        if ($request->hasFile('image')) {
            $filename = Str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();
            $path = $request->file('image')->storeAs('images', $filename, 'public');
            $user->avatar = $path;
        }

        if ($request->role === 'Client') {
            $company = Company::create([
                'name'     => $request->company ?? '',
                'country'  => $request->country ?? '',
                'state'    => $request->state ?? '',
                'city'     => $request->city ?? '',
                'zip_code' => $request->zip ?? '',
            ]);

            $user->company_id = $company->id;

            // Handle Company Logo
            if ($request->hasFile('company_logo')) {
                $filename = Str::uuid() . '.' . $request->file('company_logo')->getClientOriginalExtension();
                $path = $request->file('company_logo')->storeAs('logos', $filename, 'public');
                $company->logo = $path;
                $company->save();
            }
        }

        Mail::to($user->email)->send(new ClientCreatedMail($user, $temporaryPassword));
        
        // Save User
        $user->save();
        $user->assignRole(ucfirst($request->role));

        // Add email here to inform the client.

        return redirect()->route('freelancer.clients')->with('success', 'A new client named (' . $user->name . ') created successfully!');
    }
}
