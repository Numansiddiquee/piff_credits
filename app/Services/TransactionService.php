<?php

namespace App\Services;

use App\Models\Ledger;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

class TransactionService
{
    public function newTransaction($customer_id, $transaction_type, $details, $amount, $payment)
    {
        $uuid = Uuid::uuid7();
        $lastTransaction = Ledger::where('customer_id', $customer_id)->get()->last();
        if ($lastTransaction) {
            $lastBalance = $lastTransaction->balance;
        } else {
            $lastBalance = 0.00;
        }
        if ($amount !== null && $amount !== "" && $amount !== "null") {
            $balance = $lastBalance + $amount;
        } else {
            $balance = $lastBalance - $payment;
        }
        $newTransaction = new Ledger();
        $newTransaction->unique_id = $uuid->toString();
        $newTransaction->user_id = Auth::user()->id;
        $newTransaction->company_id = Auth::user()->company_id;
        $newTransaction->customer_id = $customer_id;
        $newTransaction->transaction = $transaction_type;
        $newTransaction->details = $details;
        $newTransaction->amount = $amount;
        $newTransaction->payment = $payment;
        $newTransaction->balance = $balance;
        $newTransaction->date = Carbon::now();
        $newTransaction->save();
    }

}
