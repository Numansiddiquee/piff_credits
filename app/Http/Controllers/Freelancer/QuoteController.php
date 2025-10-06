<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FreelancerClient;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Item;
use App\Models\LogsComment;
use App\Models\Project;
use App\Models\Quote;
use App\Models\QuoteAttachment;
use App\Models\QuoteCommunications;
use App\Models\QuoteItem;
use App\Models\QuoteNumberSetting;
use App\Models\User;
use App\Services\LogService;
use App\Services\EmailService;
use Illuminate\Support\Facades\Auth;
use GeoIp2\WebService\Client;
use Illuminate\View\View;
use Ramsey\Uuid\Uuid;
use Barryvdh\DomPDF\Facade\Pdf;

class QuoteController extends Controller
{
    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }
    
    private function generateNewQuoteNumber()
    {
        return 'QT-' . str_pad(Quote::max('id') + 1, 6, '0', STR_PAD_LEFT);
    }

    private function generateNewInvoiceNumber()
    {
        return 'INV-' . str_pad(Invoice::max('id') + 1, 6, '0', STR_PAD_LEFT);
    }

    public function new_quote()
    {
        $clients        = User::role('client')->get();
        $items          = Item::where('user_id', Auth::user()->id)->get();
        $quoteSetting   = QuoteNumberSetting::where('user_id', Auth::user()->id)->first();
        $quoteNumber    = $this->generateNewQuoteNumber();

        return view('freelancer.quote.new', compact('clients','items', 'quoteSetting', 'quoteNumber'));
    }

    public function save_new_quote(Request $request)
    {
        $uuid = Uuid::uuid7();

        $newQuote = new Quote();
        $newQuote->unique_id = $uuid->toString();
        $newQuote->user_id = Auth::id();
        $newQuote->client_id = $request->client_id;
        $newQuote->quote_number = $request->quote_id;
        $newQuote->reference = $request->reference;
        $newQuote->quote_date = date('Y-m-d', strtotime($request->quote_date));
        $newQuote->expiry_date = date('Y-m-d', strtotime($request->expiry_date));
        $newQuote->subject = $request->subject;
        $newQuote->client_notes = $request->notes;
        $newQuote->discount_type = $request->discount_type;
        $newQuote->discount_value = $request->discount ?? 0.00;
        $newQuote->terms_and_conditions = $request->terms_and_conditions;
        $newQuote->status = "Draft";
        $newQuote->save();

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('quotes/attachments', $filename, 'public');

                $newQuote->attachments()->create([
                    'file_name' => $filename,
                    'file_path' => $path,
                    'file_type' => $file->getClientOriginalExtension(),
                    'uploaded_by' => auth()->id(),
                ]);
            }
        }

        // Process Items
        $subtotal = 0;
        foreach ($request->name as $index => $name) {
            $quantity = $request->quantity[$index];
            $id = $request->id[$index];
            $price = $request->price[$index];
            $description = $request->description[$index] ?? '';
            $total = $quantity * $price;

            $subtotal += $total;

            $newQuote->items()->create([
                'user_id' => Auth::user()->id,
                'item_id' => $id,
                'item_name' => $name,
                'description' => $description,
                'quantity' => $quantity,
                'price' => $price,
                'total' => $total,
            ]);
        }

        // Discount
        $discountAmount = 0;
        if ($request->discount_type === '%') {
            $discountAmount = ($subtotal * $request->discount / 100);
        } elseif ($request->discount_type === 'fixed') {
            $discountAmount = $request->discount;
        }

        $grandTotal = $subtotal - $discountAmount;

        // Update totals
        $newQuote->update([
            'subtotal' => $subtotal,
            'total_discount' => $discountAmount,
            'grand_total' => $grandTotal,
        ]);

        $connection = FreelancerClient::where('freelancer_id', Auth::id())
                                        ->where('client_id', $request->client_id)
                                        ->first();

        if (!$connection) {
            // No connection yet → create as pending
            $connection = FreelancerClient::create([
                'freelancer_id' => Auth::id(),
                'client_id'     => $request->client_id,
                'status'        => 'pending',
                'connected_at'  => null,
            ]);
        } 

        // Logging
        $log_title = "Quote Added";
        $log_text = "New Quote: $newQuote->quote_id created for $$grandTotal";
        $log = new LogService();
        $log->addLog($request->client_id, 'quote', $newQuote->id, 'log', $log_title, $log_text, '');

        return redirect()->route('freelancer.quotes')->with('success', 'Quote Saved Successfully');
    }


    public function getCustomerProjectsAndContacts(Request $request)
    {
        $contacts = CustomerContactPerson::where('customer_id', $request->customer_id)->get();
        $projects = Project::where('customer_id', $request->customer_id)->get();
        $project_view = view('admin.quote.ajax_views.projects_select', compact('projects'))->render();
        $contacts_view = view('admin.quote.ajax_views.communication_data', compact('contacts'))->render();
        return response(['contacts' => $contacts_view, 'projects' => $project_view]);
    }

    public function edit_quote($id)
    {
        $clients        = User::role('client')->get();
        $items          = Item::where('user_id', Auth::user()->id)->get();
        $quote          = Quote::find($id);
        $quoteItems     = QuoteItem::where('quote_id', $quote->id)->get();
        $quoteSetting   = QuoteNumberSetting::where('user_id', Auth::user()->id)->first();

        return view('freelancer.quote.edit', compact('clients', 'quote', 'items', 'quoteItems', 'quoteSetting'));
    }

    public function update_quote(Request $request)
    {
        // return $request;
        $updateQuote = Quote::findOrFail($request->quote_id);

        $updateQuote->client_id           = $request->client_id;
        $updateQuote->quote_number        = $request->quote_number;
        $updateQuote->reference           = $request->reference;
        $updateQuote->quote_date          = date('Y-m-d', strtotime($request->quote_date));
        $updateQuote->expiry_date         = date('Y-m-d', strtotime($request->expiry_date));
        $updateQuote->subject             = $request->subject;
        $updateQuote->client_notes        = $request->notes;
        $updateQuote->discount_type       = $request->discount_type;
        $updateQuote->discount_value      = $request->discount_value;
        $updateQuote->terms_and_conditions = $request->terms_and_conditions;
        $updateQuote->status              = "Draft";
        $updateQuote->save();

        // Remove all existing items
        $updateQuote->items()->delete();

        $subtotal = 0;

        // Handle attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('invoices/attachments', $filename, 'public');

                $updateQuote->attachments()->create([
                    'file_name'   => $filename,
                    'file_path'   => $path,
                    'file_type'   => $file->getClientOriginalExtension(),
                    'uploaded_by' => auth()->id(),
                ]);
            }
        }

        // Handle items
        foreach ($request->name as $index => $name) {
            $quantity = $request->quantity[$index];
            $id = $request->id[$index];
            $price = $request->price[$index];
            $description = $request->description[$index] ?? '';
            $total       = $quantity * $price;
            $subtotal   += $total;

            $updateQuote->items()->create([
                'user_id'    => Auth::id(),
                'item_id'    => $id,
                'item_name'  => $name,
                'description'=> $description,
                'quantity'   => $quantity,
                'price'      => $price,
                'total'      => $total,
            ]);
        }

        // Calculate discount + totals
        $discountAmount = 0;
        if ($request->discount_type === '%') {
            $discountAmount = ($subtotal * $request->discount / 100);
        } elseif ($request->discount_type === 'fixed') {
            $discountAmount = $request->discount_value;
        }

        $grandTotal = $subtotal - $discountAmount;

        // Update totals
        $updateQuote->update([
            'subtotal'       => $subtotal,
            'total_discount' => $request->discount_value,
            'grand_total'    => $grandTotal,
        ]);

        // Logging
        $log_title = "Quote Updated";
        $log_text  = "Quote: $updateQuote->quote_id Updated";
        $log = new LogService();
        $log->addLog(
            $request->customer_id,
            'quote',
            $updateQuote->id,
            'log',
            $log_title,
            $log_text,
            User::class
        );

        return redirect()->route('freelancer.quotes')->with('success', 'Quote Updated Successfully');
    }


    public function view_quote($id)
    {

        $current_quote = Quote::find($id);
        $user = auth()->user();
        $quote_items = QuoteItem::where('quote_id', $current_quote->id)->with('item')->get();
        $quote_comments_logs = LogsComment::where('action_id', $current_quote->id)->where('action_type', 'quote')->orderBy('created_at', 'DESC')->get();
        $quotes = Quote::where("user_id", Auth::user()->id)->with('client')->get();

        return view('freelancer.quote.view', compact('quotes', 'id','current_quote', 'user', 'quote_items', 'quote_comments_logs'));
    }

    public function render(Request $request)
    {

        $current_quote = Quote::find($request->quote_id);
        $id = $request->quote_id;
        $user = auth()->user();
        $quote_items = QuoteItem::where('quote_id', $current_quote->id)->with('item')->get();
        $quote_comments_logs = LogsComment::where('action_id', $current_quote->id)->where('action_type', 'quote')->orderBy('created_at', 'DESC')->get();
        $quotes = Quote::where("company_id", Auth::user()->company_id)->with('client')->get();
        $html = view('freelancer.quote.ajax_views.details_render', compact('current_quote','id', 'user', 'quote_items', 'quote_comments_logs', 'quotes'))->render();

        return response()->json([
            'status' => true,
            'html' => $html
        ]);
    }

    public function add_comment(Request $request)
    {
        $quote_id = $request->quote_id;
        $customer_id = $request->customer_id;
        $comment = $request->comment;
        $newComment = new LogService();
        $newComment->addLog($customer_id, 'quote', $quote_id, 'comment', '', $comment,User::class);
        $quote_comments_logs = LogsComment::where('action_id', $quote_id)->where('action_type', 'quote')->orderBy('created_at', 'DESC')->get();
        $comments_blade = view('freelancer.quote.ajax_views.comments', compact('quote_comments_logs'))->render();
        return response()->json(['all_comments' => $comments_blade]);
    }

    public function generatePDF($id)
    {
        $quote = Quote::findOrFail($id);
        $quote_items = QuoteItem::where('quote_id', $quote->id)->with('item')->get();
        // return view('freelancer.partials.quotes.pdf', compact('quote','quote_items'));
        $pdf = Pdf::loadView('freelancer.partials.quotes.pdf', compact('quote', 'quote_items'));

        return $pdf->download('quote-' . $quote->quote_number . '.pdf');
    }

    public function updateSettings(Request $request)
    {
        $setting = QuoteNumberSetting::firstOrCreate([
            'company_id' => Auth::user()->company_id
        ]);
        // Update the settings
        $setting->user_id = Auth::user()->id;
        $setting->is_auto_generate = $request->quoteNumberMode == "true" ? 0 : 1;
        $setting->prefix = $request->prefix;
        $setting->next_number = $request->next_number;
        $setting->save();

        return response()->json([
            'success' => 'Settings saved successfully.',
        ]);
    }

    public function uploadInvoiceAttachment(Request $request)
    {

        $quote = Quote::findOrFail($request->quote_id);

        foreach ($request->file('attachment') as $file) {
            $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('quote/attachments', $filename, 'public');

            $quote->attachments()->create([
                'file_name' => $filename,
                'file_path' => $path,
                'file_type' => $file->getClientOriginalExtension(),
                'uploaded_by' => auth()->id(),
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function listAttachments(Quote $quote)
    {
        $attachments = $quote->attachments()->latest()->get();

        $html = view('freelancer.partials.invoice.invoice_attachments_list', compact('attachments'))->render();
        return response()->json(['html' => $html]);

    }

    public function convert_to_invoice($quote_id)
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

//            if ($request->hasFile('attachments')) {
//                foreach ($request->file('attachments') as $file) {
//                    $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
//                    $path = $file->storeAs('invoices/attachments', $filename, 'public');
//
//                    $invoice->attachments()->create([
//                        'file_name' => $filename,
//                        'file_path' => $path,
//                        'file_type' => $file->getClientOriginalExtension(),
//                        'uploaded_by' => auth()->id(),
//                    ]);
//                }
//            }


                $log_title = "Quote Converted To Invoice";
                $log_text="This Quote: $quote->quote_number has been converted to invoice and the total is : $".$quote->grand_total;
                $log = new LogService();
                $performerType =  User::class;
                $log->addLog($quote->client_id,'quote',$quote_id,'log',$log_title,$log_text,$performerType);

                return redirect()->back()->with('success', 'This quote has been converted to invoice successfully');
            }
        }
    }

    public function sendEmail(Request $request){
        // return $request;
        // $request->validate([
        //     'to_email'   => 'required|array',
        //     'to_email.*' => 'email',
        //     'cc_email.*' => 'nullable|email',
        //     'bcc_email.*'=> 'nullable|email',
        //     'subject'  => 'required|string',
        //     'body'     => 'required|string',
        //     'model_type' => 'required|string',
        //     'model_id' => 'required|integer',
        // ]);

        $attachments = [];

        if ($request->has('attachments') && is_array($request->attachments)) {
            foreach ($request->attachments as $fileName) {
                $filePath = public_path($fileName);
                $attachments[] = $filePath;
            }
        }
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments', 'public');
                $attachments[] = storage_path("app/public/{$path}");
            }
        }

        $emailData = [
            'to_email'   => $request->to_email,
            'cc_email'   => $request->cc_email ?? [],
            'bcc_email'  => $request->bcc_email ?? [],
            'subject'    => $request->subject,
            'body'       => $request->body,
            'model_type' => $request->model_type,
            'model_id'   => $request->model_id,
            'source'     => $request->source,
            'attachments' => $attachments,
        ];

        $this->emailService->sendEmail($emailData);

        $updateInvoice = Quote::find($request->model_id);
        $updateInvoice->status = 'Sent';
        $updateInvoice->update();


        return back()->with('success', 'Email sent successfully!');
    }
}
