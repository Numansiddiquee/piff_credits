<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KybDocument;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use App\Models\Quote;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('client.dashboard');
    }

    public function items()
    {
        $clientId = auth()->id();

        $items = InvoiceItem::join('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
                                ->where('invoices.client_id', $clientId)
                                ->select(
                                    'invoice_items.item_id',
                                    'invoice_items.item_name',
                                    'invoice_items.description',
                                    'invoice_items.price',
                                    DB::raw('COUNT(invoice_items.item_id) as usage_count'),
                                    DB::raw('SUM(invoice_items.quantity) as total_quantity'),
                                    DB::raw('SUM(invoice_items.total) as total_spent')
                                )
                                ->groupBy('invoice_items.item_id', 'invoice_items.item_name', 'invoice_items.description', 'invoice_items.price')
                                ->orderByDesc('usage_count')
                                ->get();

        return view('client.items', compact('items'));
    }

    public function quotes()
    {
        $quotes = Quote::with('freelancer')->where('client_id', Auth::user()->id)->get();
        return view('client.quotes')->with(compact('quotes'));
    }

    public function invoices()
    {   
        $invoices  = Invoice::with('freelancer')->where('client_id',Auth::user()->id)->get();
        return view('client.invoices')->with(compact('invoices'));
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
