<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\LogsComment;

class InvoiceController extends Controller
{
    public function view($id)
    {
        $invoice = Invoice::with('freelancer')->find($id);
        $invoice_comments_logs = LogsComment::with('performer')->where('action_id',$id)->where('action_type','invoice')->orderBy('created_at','DESC')->get();
        return view('admin.invoice.view', compact('invoice','id','invoice_comments_logs'));
    }
}
