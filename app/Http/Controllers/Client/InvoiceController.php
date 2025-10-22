<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\LogsComment;
use App\Models\User;
use App\Services\LogService;
use App\Services\NotificationService;

class InvoiceController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function view($id)
    {
        $invoice = Invoice::with('freelancer')->find($id);
        $invoice_comments_logs = LogsComment::with('performer')->where('action_id',$id)->where('action_type','invoice')->orderBy('created_at','DESC')->get();
        return view('client.invoice.view', compact('invoice','id','invoice_comments_logs'));
    }


    public function add_comment(Request $request){
        $freelancer_id = $request->client_id;
        $invoice_id = $request->invoice_id;
        $comment = $request->comment;
        $newComment = new LogService();
        $performerType =  User::class;
        $newComment->addLog($freelancer_id,'invoice',$invoice_id,'comment','Client Comment',$comment,$performerType);
        $invoice = Invoice::find($invoice_id);
        // Create in-app notification for the client
        $this->notificationService->createNotification(
            $freelancer_id, 
            auth()->id(),
            'client_comment',
            'New Comment from ' . auth()->user()->name,
            'Client ' . auth()->user()->name . ' commented on Invoice #' . $invoice->invoice_number . ': "' . $request->message . '"',
            route('freelancer.invoice.show', $invoice->id)
        );
        $invoice_comments_logs = LogsComment::with('performer')->where('action_id',$invoice_id)->where('action_type','invoice')->where('type','comment')->orderBy('created_at','DESC')->get();
        $comments_blade = view('client.partials.invoice.comments', compact('invoice_comments_logs'))->render();
        return response()->json(['all_comments'=>$comments_blade]);
    }
}
