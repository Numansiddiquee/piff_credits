<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KybDocument;

class DashboardController extends Controller
{
    public function index()
    {
        return view('client.dashboard');
    }

    public function items()
    {
        return view('client.items');
    }

    public function quotes()
    {
        return view('client.quotes');
    }

    public function invoices()
    {
        return view('client.invoices');
    }

    public function payments()
    {
        return view('client.payments');
    }

    public function kyb()
    {
        $userId = auth()->user()->id;
        $documents = KybDocument::whereHas('verification', function($q) use ($userId) {
                                    $q->where('user_id', $userId);
                                })->get();

        return view('client.kyb')->with(compact('documents'));
    }

    public function balance()
    {
        return view('client.balance');
    }

    public function transactions()
    {
        return view('client.transactions');
    }

    public function transactionHistory()
    {
        return view('client.transaction_history');
    }

    public function accounting()
    {
        return view('client.accounting');
    }

    public function support()
    {
        return view('client.support');
    }
}
