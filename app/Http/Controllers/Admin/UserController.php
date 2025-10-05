<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;    
use App\Models\Company;    
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function create(){
        $roles = Role::where('name', '!=', 'super-admin')->get();
        return view('admin.user.create')->with(compact('roles'));
    }

    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'phone_number'  => 'required|string|max:20',
            'password'      => 'required|string|min:6',
            'role'          => 'required|in:Client,Freelancer,Super Admin', // Adjust roles if needed
            'image'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'company_logo'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'company'       => 'nullable|string|max:255',
            'country'       => 'nullable|string|max:100',
            'state'         => 'nullable|string|max:100',
            'city'          => 'nullable|string|max:100',
            'zip'           => 'nullable|string|max:20',
        ]);

        $user               = new User();
        $user->fname        = $request->first_name;
        $user->lname        = $request->last_name;
        $user->name         = $request->first_name . ' ' . $request->last_name;
        $user->email        = $request->email;
        $user->phone        = $request->phone_number;
        $user->company_name = lcfirst($request->role) === 'client' ? $request->company : null;
        $user->password     = Hash::make($request->password);
        $user->plain_hash   = $request->password;
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

        // Save User
        $user->save();
        $user->assignRole(ucfirst($request->role));

        return redirect()->route('admin.users')->with('success', 'A new $request->role created successfully!');
    }


    public function view($id){
        $user = User::find($id);
        $action = 'view';
        return view('admin.user.view')->with(compact('user','action'));
    }

    public function edit($id){
        $user = User::find($id);
        $action = 'edit';
        return view('admin.user.view')->with(compact('user','action'));
    }


    public function update(Request $request)
    {
        $user = User::find($request->user_id);
        // return $request;
        $user->name = trim($request->fname . ' ' . $request->lname);
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->phone = $request->phone;

        // Handle company data ONLY if role is client
        if ($user->roles->first()->name === 'Client') {
            $user->company_name = $request->company;

            if ($user->company) {
                $user->company->update([
                    'name'     => $request->company,
                    'country'  => $request->country,
                    'state'    => $request->state,
                    'city'     => $request->city,
                    'zip_code' => $request->zip,
                ]);
            } else {
                $company = Company::create([
                    'name'     => $request->company,
                    'country'  => $request->country,
                    'state'    => $request->state,
                    'city'     => $request->city,
                    'zip_code' => $request->zip,
                ]);
                $user->company_id = $company->id;
            }
        }

        $user->save();

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('images', $filename, 'public');

            // Delete old avatar if needed
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $user->avatar = $path;
            $user->save();
        }

        // Handle company logo upload (Clients only)
        if ($user->roles->first()->name === 'Client' && $request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('logos', $filename, 'public');

            if ($user->company) {
                // Delete old logo if needed
                if ($user->company->logo) {
                    Storage::disk('public')->delete($user->company->logo);
                }

                $user->company->logo = $path;
                $user->company->save();
            }
        }


        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
