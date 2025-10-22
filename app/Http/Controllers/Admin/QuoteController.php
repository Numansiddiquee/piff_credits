<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Quote;
use App\Models\LogsComment;
use App\Models\QuoteItem;
use App\Services\LogService;
use Illuminate\Support\Facades\Mail;
use App\Models\FreelancerClient;
use App\Mail\QuoteStatusMail;

class QuoteController extends Controller
{
    public function view($id){
        $current_quote = Quote::find($id);
        $quote_items = QuoteItem::where('quote_id',$current_quote->id)->with('item')->get();
        $quote_comments_logs = LogsComment::with('performer')->where('action_id',$id)->where('action_type','quote')->orderBy('created_at','DESC')->get();
        return view('admin.quote.view',compact('current_quote','quote_items','quote_comments_logs'));
    }

    public function updateStatus(Request $request)
    {
        $quote = Quote::findOrFail($request->quote_id);
        $quote->status = $request->status;
        $quote->save();

        $connectionStatus = strtolower($request->status) === 'accepted' ? 'active' : 'pending';

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

        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }

    public function addComment(Request $request){

        $quote_id = $request->quote_id;
        $client_id = $request->client_id;
        $comment = $request->comment;
        $newComment = new LogService();
        $performerType =  User::class;
        $newComment->addLog($client_id,'quote',$quote_id,'comment','',$comment,$performerType);
        $quote_comments_logs = LogsComment::with('performer')->where('action_type','quote')->where('action_id',$quote_id)->orderBy('created_at','DESC')->get();
        $comments_blade = view('client.partials.quote.comments', compact('quote_comments_logs'))->render();
        return response()->json(['all_comments'=>$comments_blade]);

    }
}
