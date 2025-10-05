<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Item;
use App\Models\Quote;
use Illuminate\Support\Facades\Auth;
use App\Models\VerificationRequest;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function items()
    {
        $items = Item::where('company_id',Auth::user()->company_id)->get();
        return view('admin.items')->with(compact('items'));
    }

    public function quotes()
    {
        $quotes = Quote::where('company_id', Auth::user()->company_id)->with('client','freelancer')->get();
        return view('admin.quotes')->with(compact('quotes'));
    }

    public function invoices()
    {
        $invoices  = Invoice::with('client','freelancer')->where('company_id',Auth::user()->company_id)->get();
        return view('admin.invoices')->with(compact('invoices'));
    }

    public function payments()
    {
        return view('admin.payments');
    }

    public function users()
    {
        $users = User::paginate(15);
        return view('admin.users')->with(compact('users'));
    }

    public function verificationRequest()
    {
        $requests = VerificationRequest::with('user')->latest()->get();
        return view('admin.verification_requests', compact('requests'));
    }
}
