<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Quote;
use App\Models\Item;
use App\Models\Invoice;
use App\Models\LogsComment;
use App\Models\QuoteItem;
use App\Models\InvoiceItem;
use App\Services\LogService;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\FreelancerClient;
use App\Mail\QuoteStatusMail;
use Ramsey\Uuid\Uuid;

class QuoteController extends Controller
{

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function view($id){
        $current_quote = Quote::find($id);
        $quote_items = QuoteItem::where('quote_id',$current_quote->id)->with('item')->get();
        $quote_comments_logs = LogsComment::with('performer')->where('action_id',$id)->where('action_type','quote')->orderBy('created_at','DESC')->get();
        return view('client.quote.view',compact('current_quote','quote_items','quote_comments_logs'));
    }

    public function updateStatus(Request $request)
    {
        $quote = Quote::findOrFail($request->quote_id);
        $oldStatus = $quote->status;
        $quote->status = $request->status;
        $quote->save();

        $connectionStatus = strtolower($request->status) === 'accepted' ? 'active' : 'pending';
        
        if($connectionStatus == 'active'){
            $this->convert_to_invoice($request->quote_id);
        }

        $connection = FreelancerClient::firstOrCreate(
                [
                    'freelancer_id' => $quote->user_id,
                    'client_id'     => $quote->client_id,
                ],
                [
                    'status'       => $connectionStatus,
                    'connected_at' => now(),
                ]
            );

            if ($connection->status !== 'active') {
                $connection->status = 'active';
                $connection->connected_at = now();
                $connection->save();
            }

        $freelancer = $quote->freelancer;
        Mail::to($freelancer->email)->send(new QuoteStatusMail($quote, $request->status));

        $logService = new LogService();
        $message = 'Quote #' . $quote->id . ' status changed from "' . $oldStatus . '" to "' . $request->status . '" by ' . auth()->user()->name;
        $logService->addLog(
            $quote->client_id,           
            'quote',                     
            $quote->id,                  
            'log',                       
            'Quote Status Updated',      
            $message,                    
            User::class                  
        );

        $this->notificationService->createNotification(
            $quote->user_id,               
            auth()->id(),                    
            'quote_status_updated',          
            'Quote Status Updated',          
            'Quote #' . $quote->id . ' status has been updated to "' . $request->status . '" by ' . auth()->user()->name,
            route('client.quote.view', $quote->id)
        );

        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }

    public function addComment(Request $request){

        $quote_id = $request->quote_id;
        $freelancer_id = $request->freelancer_id;
        $comment = $request->comment;
        $newComment = new LogService();
        $performerType =  User::class;
        $newComment->addLog($freelancer_id,'quote',$quote_id,'comment','Client Comment',$comment,$performerType);
        $quote = Quote::find($quote_id);
        // Create in-app notification for the client
        $this->notificationService->createNotification(
            $freelancer_id, 
            auth()->id(),
            'client_comment',
            'New Comment from ' . auth()->user()->name,
            'Client ' . auth()->user()->name . ' commented on Quote #' . $quote->quote_number . ': "' . $request->message . '"',
            route('freelancer.quote.view_quote', $quote->id)
        );
        $quote_comments_logs = LogsComment::with('performer')->where('action_type','quote')->where('action_id',$quote_id)->orderBy('created_at','DESC')->get();
        $comments_blade = view('client.partials.quote.comments', compact('quote_comments_logs'))->render();
        return response()->json(['all_comments'=>$comments_blade]);

    }

    public function getAwaitingCount(Request $request)
    {
        $clientId = $request->client_id;

        if (!$clientId) {
            return response()->json(['error' => 'Client ID required'], 400);
        }

        $count = Quote::where('client_id', $clientId)
                      ->where('status', 'awaiting_review')
                      ->count();

        return response()->json(['count' => $count]);
    }

    public function awaitingQuotes(Request $request)
    {
        $clientId = auth()->id();
        $quotes = Quote::where('client_id', $clientId)->where('status', 'awaiting_review')->orderBy('created_at', 'desc')->get();

        return view('client.quote.awaiting', compact('quotes'));
    }

    private function convert_to_invoice($quote_id)
    {
        $quote = Quote::find($quote_id);
        if ($quote) {
            if ($quote->status === "Converted To Invoice") {
                return redirect()->back()->with('success', 'Quote already converted to Invoice');
            } else {


                $invoice_date = date('Y-m-d', strtotime(str_replace(',', '', $quote->quote_date)));
                $invoice_due_date = date('Y-m-d', strtotime(str_replace(',', '', $quote->expiry_date)));
                $discount_type = "fixed";
                if ($quote->discount_type == 'percentage') {
                    $discount_type = "%";
                } else {
                    $discount_type = "fixed";
                }

                $uuid = Uuid::uuid7();

                $invoice = Invoice::create([
                    'client_id' => $quote->client_id,
                    'unique_id' => $uuid->toString(),
                    'user_id' => Auth::user()->id,
                    'invoice_number' => $this->generateNewInvoiceNumber(),
                    'order_number' => $quote->reference,
                    'subject' => $quote->subject,
                    'invoice_date' => $invoice_date,
                    'due_date' => $invoice_due_date,
                    'discount' => $quote->discount_value ?? 0.00,
                    'discount_type' => $discount_type,
                    'discounted_amount' => $quote->total_discount ?? 0.00,
                    'terms_condition' => $quote->terms_condition,
                    'notes' => $quote->client_notes,
                    'status' => 'Converted To Invoice',
                    'subtotal' => $quote->subtotal,
                    'total' => $quote->grand_total,
                    'due' => $quote->grand_total,
                ]);

                $quote_items = QuoteItem::where("quote_id", $quote_id)->get();
                foreach ($quote_items as $quote_item) {
                    $item = Item::find($quote_item->item_id);
                    if ($item) {
                        $item_name = $item->name;
                    } else {
                        $item_name = "";
                    }
                    $invoice_item = new InvoiceItem();
                    $invoice_item->user_id = Auth::user()->id;
                    $invoice_item->company_id = Auth::user()->company_id;
                    $invoice_item->invoice_id = $invoice->id;
                    $invoice_item->item_id = $quote_item->item_id;
                    $invoice_item->item_name = $item_name;
                    $invoice_item->description = $quote_item->description;
                    $invoice_item->quantity = $quote_item->quantity;
                    $invoice_item->price = $quote_item->price;
                    $invoice_item->total = $quote_item->total;
                    $invoice_item->save();
                }
                $quote->status = "Converted To Invoice";
                $quote->update();

                $log_title = "Quote Converted To Invoice";
                $log_text="This Quote: $quote->quote_number has been converted to invoice and the total is : $".$quote->grand_total;
                $log = new LogService();
                $performerType =  User::class;
                $log->addLog($quote->client_id,'quote',$quote_id,'log',$log_title,$log_text,$performerType);
                // Notification for client
                $this->notificationService->createNotification(
                    $quote->client_id,
                    auth()->id(),  
                    'converted_to_invoice',
                    'Quote Converted To Invoice',
                    'This Quote: '.$quote->quote_number.' has been converted to invoice and the total is : $'.$quote->grand_total.'.',
                    route('client.quote.view', $quote->id)
                );
                // Notification for freelancer
                $this->notificationService->createNotification(
                    $quote->user_id,
                    auth()->id(),  
                    'converted_to_invoice',
                    'Quote Converted To Invoice',
                    'This Quote: '.$quote->quote_number.' has been converted to invoice and the total is : $'.$quote->grand_total.'.',
                    route('freelancer.quote.view_quote', $quote->id)
                );

                return redirect()->back()->with('success', 'This quote has been converted to invoice successfully');
            }
        }
    }

    private function generateNewInvoiceNumber()
    {
        return 'INV-' . str_pad(Invoice::max('id') + 1, 6, '0', STR_PAD_LEFT);
    }

}
