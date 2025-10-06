<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KycDocument;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Item;
use App\Models\Quote;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('freelancer.dashboard');
    }

    public function items()
    {
        $items = Item::where('user_id',Auth::user()->id)->get();
        return view('freelancer.items')->with(compact('items'));
    }

    public function quotes()
    {
        $quotes = Quote::with('client')->where('user_id', Auth::user()->id)->get();
        return view('freelancer.quotes')->with(compact('quotes'));
    }

    public function invoices()
    {
        $invoices  = Invoice::with('client')->where('user_id',Auth::user()->id)->get();
        return view('freelancer.invoices')->with(compact('invoices'));
    }

    public function payments()
    {
        return view('freelancer.payments');
    }

    public function kyc()
    {
        $userId = auth()->user()->id;
        $documents = KycDocument::whereHas('verification', function($q) use ($userId) {
                                    $q->where('user_id', $userId);
                                })->get();

        return view('freelancer.kyc')->with(compact('documents'));
    }

    public function balance()
    {
        return view('freelancer.balance');
    }

    public function transactions()
    {
        return view('freelancer.transactions');
    }

    public function transactionHistory()
    {
        return view('freelancer.transaction_history');
    }

    public function reports()
    {
        return view('freelancer.reports');
    }

    public function accounting()
    {
        return view('freelancer.accounting');
    }

    public function clients()
    {   
        $freelancer = Auth::user();
        $connections = $freelancer->freelancerClients()->withCount(['invoices'])->get();

        return view('freelancer.clients')->with(compact('connections'));
    }

    public function support()
    {
        return view('freelancer.support');
    }
}
