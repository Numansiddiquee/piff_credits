<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\LogsComment;
use App\Models\User;
use App\Models\Company;    
use App\Services\LogService;
use App\Services\EmailService;
use App\Services\NotificationService;
use App\Services\TransactionService;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Item;
use App\Models\WriteOff;
use App\Models\InvoiceItem;
use App\Models\InvoiceNumberSetting;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash; 

class InvoiceController extends Controller
{
    protected $emailService;
    protected $notificationService;

    public function __construct(EmailService $emailService, NotificationService $notificationService)
    {
        $this->emailService = $emailService;
        $this->notificationService = $notificationService;
    }

    public function create()
    {
        // $clients        = User::role('client')->get();
        $freelancer     = Auth::user();
        $clients        = $freelancer->freelancerClients()->where('status', 'active')->get();

        $invoiceSetting = InvoiceNumberSetting::where('user_id',Auth::user()->id)->first();
        $items          = Item::where('user_id',Auth::user()->id)->get();
        $invoiceNumber  = $this->generateNewInvoiceNumber();
        return view('freelancer.invoice.create')->with(compact('clients','invoiceSetting','items','invoiceNumber'));
    }

    // Store a new invoice

    public function store(Request $request)
    {
        // return $request;
        $invoice_date = date('Y-m-d', strtotime(str_replace(',', '', $request->invoice_date)));
        $invoice_due_date = date('Y-m-d', strtotime(str_replace(',', '', $request->invoice_due_date)));
        $uuid = Uuid::uuid7();
        $invoice = Invoice::create([
            'client_id' => $request->client_id,
            'unique_id' => $uuid->toString(),
            'user_id' => Auth::user()->id,
            'invoice_number' => $request->invoice_number,
            'subject' => $request->invoice_subject,
            'invoice_date' => $invoice_date,
            'due_date' => $invoice_due_date,
            'discount' => $request->discount ?? 0.00,
            'discount_type' => $request->discount_type,
            'discounted_amount' => $request->discounted_amount ?? 0.00,
            'terms_condition' => $request->terms_condition,
            'notes' => $request->notes,
            'status' => 'Draft',
            'subtotal' => 0,
            'total' => 0,
            'due' => 0,
        ]);

        $subtotal = 0;

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('invoices/attachments', $filename, 'public');

                $invoice->attachments()->create([
                    'file_name' => $filename,
                    'file_path' => $path,
                    'file_type' => $file->getClientOriginalExtension(),
                    'uploaded_by' => auth()->id(),
                ]);
            }
        }

        foreach ($request->name as $index => $name) {
            $quantity = $request->quantity[$index];
            $price = $request->price[$index];
            $description = $request->description[$index] ?? '';
            $total = $quantity * $price;
            $subtotal += $total;

            $itemId = $request->id[$index] ?? null;
            $isNew = ($request->is_new[$index] ?? 0) == 1;

            // If new item (no existing ID or flagged as new), create in items table
            if ($isNew || empty($itemId)) {
                $newItem = Item::create([
                    'user_id' => Auth::user()->id,
                    'type' => 'services',
                    'name' => $name,
                    'description' => $description,
                    'selling_price' => $price,
                ]);
                $itemId = $newItem->id;
            }

            $invoice->items()->create([
                'user_id' => Auth::user()->id,
                'item_id' => $itemId,
                'item_name' => $name,
                'description' => $description,
                'quantity' => $quantity,
                'price' => $price,
                'total' => $total,
            ]);
        }

        $discountAmount = ($request->discount_type === '%')
            ? ($subtotal * $request->discount / 100)
            : $request->discount;

        $shippingCharges = $request->shipping_charges ?? 0;
        $total = $subtotal - $discountAmount + $shippingCharges;

        $invoice->update([
            'subtotal' => $subtotal,
            'total' => $total,
            'due' => $total,
        ]);

        $log_title = "Invoice Created";
        $log_text = "New Invoice: $request->invoice_number Created for $" . $total;
        $log = new LogService();
        $performerType = User::class;
        $log->addLog($request->client_id, 'invoice', $invoice->id, 'log', $log_title, $log_text, $performerType);

        $this->notificationService->createNotification(
            $request->client_id,
            auth()->user()->id,
            'invoice_created',
            'New Invoice Received',
            'A new Invoice (#' . $invoice->invoice_number . ') has been created for you by ' . auth()->user()->name,
            route('client.invoice.view', $invoice->id)
        );
        return redirect()->route('freelancer.invoices');
    }

    public function store_old(Request $request)
    {
        // return $request;
        $invoice_date = date('Y-m-d', strtotime(str_replace(',', '', $request->invoice_date)));
        $invoice_due_date = date('Y-m-d', strtotime(str_replace(',', '', $request->invoice_due_date)));
        $uuid = Uuid::uuid7();
        $invoice = Invoice::create([
            'client_id' => $request->client_id,
            'unique_id' => $uuid->toString(),
            'user_id' => Auth::user()->id,
            'invoice_number' => $request->invoice_number,
            'subject' => $request->invoice_subject,
            'invoice_date' => $invoice_date,
            'due_date' => $invoice_due_date,
            'discount' => $request->discount ?? 0.00,
            'discount_type' => $request->discount_type,
            'discounted_amount' => $request->discounted_amount ?? 0.00,
            'terms_condition' => $request->terms_condition,
            'notes' => $request->notes,
            'status' => 'Draft',
            'subtotal' => 0,
            'total' => 0,
            'due' => 0,
        ]);
//        dd($invoice->id);

        $subtotal = 0;

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('invoices/attachments', $filename, 'public');

                $invoice->attachments()->create([
                    'file_name' => $filename,
                    'file_path' => $path,
                    'file_type' => $file->getClientOriginalExtension(),
                    'uploaded_by' => auth()->id(),
                ]);
            }
        }

        foreach ($request->name as $index => $name) {
            $quantity = $request->quantity[$index];
            $id = $request->id[$index];
            $price = $request->price[$index];
            $description = $request->description[$index] ?? '';
            $total = $quantity * $price;
            $subtotal += $total;

            $invoice->items()->create([
                'user_id' => Auth::user()->id,
                'item_id' => $id,
                'item_name' => $name,
                'description' => $description,
                'quantity' => $quantity,
                'price' => $price,
                'total' => $total,
            ]);
        }

        $discountAmount = ($request->discount_type === '%')
            ? ($subtotal * $request->discount / 100)
            : $request->discount;

        $total = $subtotal - $discountAmount + $request->shipping_charges;

        $invoice->update([
            'subtotal' => $subtotal,
            'total' => $total,
            'due' => $total,
        ]);
        $log_title="Invoice Created";
        $log_text="New Invoice: $request->invoice_number Created for $".$total;
        $log = new LogService();
        $performerType =  User::class;
        $log->addLog($request->client_id,'invoice',$invoice->id,'log',$log_title,$log_text,$performerType);
        return redirect()->route('freelancer.invoices');
    }

    public function show($id)
    {
        $invoice = Invoice::find($id);
        $user = auth()->user();
        $invoices = Invoice::where('user_id',Auth::user()->id)->get();
        $invoice_comments_logs = LogsComment::where('action_id',$invoice->id)->where('action_type','invoice')->orderBy('created_at','DESC')->get();
        return view('freelancer.invoice.show', compact('invoice','invoices','id','invoice_comments_logs','user'));
    }

    public function render(Request $request)
    {
        $id = $request->id;
        $user = auth()->user();
        $invoice = Invoice::find($id);
        $invoice_comments_logs = LogsComment::where('action_id',$invoice->id)->where('action_type','invoice')->orderBy('created_at','DESC')->get();
        $html =  view('freelancer.invoice.render', compact('invoice','invoice_comments_logs','id','user'))->render();

        return response()->json([
           'status' => true,
           'html'   => $html,
        ]);
    }

    public function edit($id)
    {
        $invoice        = Invoice::find($id);
        // $clients        = User::role('client')->get();
        $freelancer     = Auth::user();
        $clients        = $freelancer->freelancerClients()->where('status', 'active')->get();
        
        $invoiceSetting = InvoiceNumberSetting::where('user_id',Auth::user()->id)->first();
        $items          = Item::where('user_id',Auth::user()->id)->get();

        return view('freelancer.invoice.edit')->with(compact('clients','invoiceSetting','items','invoice','id'));
    }

    public function update(Request $request)
    {
       // return $request;

        $invoice_date = date('Y-m-d', strtotime(str_replace(',', '', $request->invoice_date)));
        $invoice_due_date = date('Y-m-d', strtotime(str_replace(',', '', $request->invoice_due_date)));

        // Find the existing invoice
        $invoice = Invoice::findOrFail($request->invoice_id);

        // Update the invoice fields
        $invoice->update([
            'client_id' => $request->client_id,
            'invoice_date' => $invoice_date,
            'subject' => $request->invoice_subject,
            'due_date' => $invoice_due_date,
            'terms_condition' => $request->terms_condition,
            'discount' => $request->discount,
            'discount_type' => $request->discount_type,
            'discounted_amount' => $request->discounted_amount,
            'notes' => $request->notes,
        ]);

        $subtotal = 0;

        // Remove all existing items
        $invoice->items()->delete();

        // Recalculate subtotal and add updated items
        $subtotal = 0;

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('invoices/attachments', $filename, 'public');

                $invoice->attachments()->create([
                    'file_name' => $filename,
                    'file_path' => $path,
                    'file_type' => $file->getClientOriginalExtension(),
                    'uploaded_by' => auth()->id(),
                ]);
            }
        }

        foreach ($request->name as $index => $name) {
            $quantity = $request->quantity[$index];
            $id = $request->id[$index];
            $price = $request->price[$index];
            $description = $request->description[$index] ?? '';
            $total = $quantity * $price;
            $subtotal += $total;

            // Recreate invoice item
            $invoice->items()->create([
                'item_id' => $id,
                'item_name' => $name,
                'description' => $description,
                'quantity' => $quantity,
                'price' => $price,
                'total' => $total,
            ]);
        }

        // Recalculate discount and total
        $discountAmount = ($request->discount_type === '%')
            ? ($subtotal * $request->discount / 100)
            : $request->discount;

        $total = $subtotal - $discountAmount;

        // Update invoice totals
        $invoice->update([
            'subtotal' => $subtotal,
            'total' => $total,
            'due' => $total,
        ]);

        $log_title="Invoice Updated";
        $log_text="Invoice: $invoice->invoice_number Updated";
        $log = new LogService();
        $log->addLog($request->client_id,'invoice',$request->invoice_id,'log',$log_title,$log_text,User::class);

        $this->notificationService->createNotification(
            $request->client_id,
            auth()->user()->id,
            'invoice_updated',
            'Invoice Updated',
            'A Invoice (#' . $invoice->invoice_number . ') has been Updated for you by ' . auth()->user()->name,
            route('client.invoice.view', $invoice->id)
        );

        return redirect()->route('freelancer.invoices')->with('success', 'Invoice updated successfully.');
    }

    public function createClient()
    {
        return view('freelancer.invoice.client.create');
    }

    public function storeClient(Request $request)
    {
        // return $request;
        $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'phone_number'  => 'required|string|max:20',
            'password'      => 'required|string|min:6',
            'role'          => 'required|in:Client,Freelancer,Super Admin', // Adjust roles if needed
            'image'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'company_logo'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'company'       => 'nullable|string|max:255',
            'country'       => 'nullable|string|max:100',
            'state'         => 'nullable|string|max:100',
            'city'          => 'nullable|string|max:100',
            'zip'           => 'nullable|string|max:20',
        ]);

        $user               = new User();
        $user->fname        = $request->first_name;
        $user->lname        = $request->last_name;
        $user->name         = $request->first_name . ' ' . $request->last_name;
        $user->email        = $request->email;
        $user->phone        = $request->phone_number;
        $user->company_name = $request->company ?? null;
        $user->password     = Hash::make($request->password);
        $user->plain_hash   = $request->password;
        $user->user_type    = lcfirst($request->role);
        $user->login_type   = 'email';

        if ($request->hasFile('image')) {
            $filename = Str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();
            $path = $request->file('image')->storeAs('images', $filename, 'public');
            $user->avatar = $path;
        }

        if ($request->role === 'Client') {
            $company = Company::create([
                'name'     => $request->company ?? '',
                'country'  => $request->country ?? '',
                'state'    => $request->state ?? '',
                'city'     => $request->city ?? '',
                'zip_code' => $request->zip ?? '',
            ]);

            $user->company_id = $company->id;

            // Handle Company Logo
            if ($request->hasFile('company_logo')) {
                $filename = Str::uuid() . '.' . $request->file('company_logo')->getClientOriginalExtension();
                $path = $request->file('company_logo')->storeAs('logos', $filename, 'public');
                $company->logo = $path;
                $company->save();
            }
        }

        // Save User
        $user->save();
        $user->assignRole(ucfirst($request->role));

        // Add email here to inform the client.

        return redirect()->route('freelancer.invoice.create')->with('success', 'A new client named (' . $user->name . ') created successfully!');
    }

    public function updateSettings(Request $request)
    {
        $setting = InvoiceNumberSetting::firstOrCreate([
            'user_id' => Auth::user()->id
        ]);

        // Update the settings
        $setting->user_id = Auth::user()->id;
        $setting->is_auto_generate = $request->invoiceNumberMode == 'true' ? 0 : 1;
        $setting->prefix = $request->prefix;
        $setting->next_number = $request->next_number;
        $setting->save();

        return response()->json([
            'success' => 'Settings saved successfully.',
        ]);
    }

    public function clone($id)
    {
        $originalInvoice = Invoice::with('items')->findOrFail($id);
        $uuid = Uuid::uuid7();
        $newInvoice = $originalInvoice->replicate();
        $newInvoice->unique_id = $uuid->toString(); // Generate a unique invoice number
        $newInvoice->invoice_number = $this->generateNewInvoiceNumber(); // Generate a unique invoice number
        $newInvoice->save();

        foreach ($originalInvoice->items as $item) {
            $newInvoiceItem = $item->replicate();
            $newInvoiceItem->invoice_id = $newInvoice->id;
            $newInvoiceItem->save();
        }

        return redirect()->route('freelancer.invoices')->with('success', 'Invoice cloned successfully!');
    }

    private function generateNewInvoiceNumber()
    {
        return 'INV-' . str_pad(Invoice::max('id') + 1, 6, '0', STR_PAD_LEFT);
    }

    public function sendEmail(Request $request){
        //  return $request;
        $request->validate([
            'to_email'   => 'required|array',
            'to_email.*' => 'email',
            'cc_email.*' => 'nullable|email',
            'bcc_email.*'=> 'nullable|email',
            'subject'  => 'required|string',
            'body'     => 'required|string',
            'model_type' => 'required|string',
            'model_id' => 'required|integer',
        ]);

        $attachments = [];

        if ($request->has('attachments') && is_array($request->attachments)) {
            foreach ($request->attachments as $fileName) {
                $filePath = public_path($fileName);
                $attachments[] = $filePath;
            }
        }
        // dd($attachments);
        // If any files are directly uploaded (via file input), handle them
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                // Store the file and get the path
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

        $updateInvoice = Invoice::find($request->model_id);
        $updateInvoice->status = 'Sent';
        $updateInvoice->update();

//      Ledger Entry
        // $transaction = new TransactionService();
        // $transaction_details = $updateInvoice->invoice_number.' -due on '.$updateInvoice->due_date;
        // $transaction->newTransaction($updateInvoice->customer_id, 'Invoice', $transaction_details, $updateInvoice->total, '');

        return back()->with('success', 'Email sent successfully!');
    }

    public function uploadAttachment(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,docx|max:10240',
        ]);

        $filePath = $request->file('file')->store('invoices/emails-attachments', 'public');

        // Generate public URL
        $publicUrl = asset('storage/' . $filePath);

        return response()->json([
            'temp_link' => $publicUrl,
        ]);

        //        $filePath = $request->file('file')->store('invoices/emails-attachments', 'public');
        //
        //        $tempLink = Storage::disk('public')->temporaryUrl($filePath, now()->addMinutes(60));
        //
        //        // Return the URL as response
        //        return response()->json([
        //            'temp_link' => $tempLink
        //        ]);
    }

    public function stopReminder(Request $request)
    {
        $invoice = Invoice::findOrFail($request->invoice_id);

        $invoice->send_reminder = false;
        $invoice->save();

        return response()->json([
            'success' => true,
            'message' => 'Reminder successfully stopped!',
        ]);
    }

    public function updateDueDetails(Request $request)
    {

        $invoice = Invoice::findOrFail($request->invoice_id);
        
        if (strtolower($invoice->status)  === 'Paid' || strtolower($invoice->status)  === 'written off') {
            return response()->json(['error' => 'You cannot do this action. Please contact support.'], 400);
        }

        $invoice->due_date = $request->due_date;
        $invoice->payment_delay_note = $request->payment_delay_note;
        $invoice->save();

        $logService = new LogService();
        $message = 'Freelancer ' . auth()->user()->name . ' updated the due date with this note ('.$invoice->payment_delay_note.') for Invoice #' . $invoice->invoice_number;
        $logService->addLog($invoice->client_id,'invoice',$invoice->id,'log', 'Invoice Due Updated', $message,User::class);

        $this->notificationService->createNotification(
            $invoice->client_id,
            auth()->id(),
            'invoice_due_updated',
            'Invoice Updated',
            'The due date with this note  ('.$invoice->payment_delay_note.')  for Invoice #' . $invoice->invoice_number . ' has been updated by ' . auth()->user()->name,
            route('client.invoice.view', $invoice->id)
        );

        return response()->json([
            'success' => true,
            'message' => 'Invoice updated successfully.',
        ]);
    }

    public function generatePDF($id)
    {
        $invoice = Invoice::findOrFail($id);
       // return view('freelancer.partials.invoice.pdf', compact('invoice'));
        $pdf = Pdf::loadView('freelancer.partials.invoice.pdf', compact('invoice'));

        return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
    }

    public function writeOff(Request $request)
    {
        $invoice = Invoice::findOrFail($request->invoice_id);
        $client_id = $invoice->client_id;

        if ($invoice->status === 'Paid') {
            return response()->json(['error' => 'This invoice is already paid and cannot be written off.'], 400);
        }

        if ($invoice->writeOff()->exists()) {
            return response()->json(['error' => 'This invoice has already been written off.'], 400);
        }

        $writeOff = WriteOff::create([
            'user_id'       => Auth::id(),
            'invoice_id'    => $invoice->id,
            'writeoff_date' => $request->writeoff_date,
            'reason'        => $request->reason,
        ]);

        $logService = new LogService();
        $message = 'Freelancer ' . auth()->user()->name . ' performed a write-off on Invoice #' . 
                    $invoice->invoice_number . ' with reason: "' . $request->reason . '"';
        $logService->addLog($client_id, 'invoice', $invoice->id, 'log', 'Invoice Write-Off', $message, User::class);

        $this->notificationService->createNotification(
            $client_id,
            auth()->id(),
            'invoice_writeoff',
            'Invoice Written Off',
            'Invoice #' . $invoice->invoice_number . ' has been written off by ' . auth()->user()->name . '.',
            route('client.invoice.view', $invoice->id)
        );

        $invoice->update(['status' => 'Written Off']);

        return response()->json(['message' => 'Invoice written off successfully.']);
    }


    public function add_comment(Request $request){
        $client_id = $request->client_id;
        $invoice_id = $request->invoice_id;
        $comment = $request->comment;
        $newComment = new LogService();
        $newComment->addLog($client_id,'invoice',$invoice_id,'comment','Freelancer Comment',$comment,User::class);
        $invoice = Invoice::find($invoice_id);
        // Create in-app notification for the client
        $this->notificationService->createNotification(
            $client_id, 
            auth()->id(),
            'freelancer_comment',
            'New Comment from ' . auth()->user()->name,
            'Freelancer ' . auth()->user()->name . ' commented on Invoice #' . $invoice->invoice_number . ': "' . $request->message . '"',
            route('client.invoice.view', $invoice->id)
        );

        $invoice_comments_logs = LogsComment::where('action_id',$invoice_id)->where('action_type','invoice')->orderBy('created_at','DESC')->get();
        $comments_blade = view('freelancer.invoice.ajax_views.comments', compact('invoice_comments_logs'))->render();
        return response()->json(['all_comments'=>$comments_blade]);
    }

    public function uploadInvoiceAttachment(Request $request){

        $invoice = Invoice::findOrFail($request->invoice_id);

        foreach ($request->file('attachment') as $file) {
            $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('invoices/attachments', $filename, 'public');

            $invoice->attachments()->create([
                'file_name' => $filename,
                'file_path' => $path,
                'file_type' => $file->getClientOriginalExtension(),
                'uploaded_by' => auth()->id(),
            ]);
        }

        $this->notificationService->createNotification(
            $invoice->client_id,
            auth()->id(),  
            'attachment_uploaded',
            'New Attachment Uploaded',
            'Freelancer ' . auth()->user()->name . ' uploaded new attachment(s) for Invoice #' . $invoice->invoice_number . '.',
            route('client.invoice.view', $invoice->id)
        );

        $newComment = new LogService();
        $message  = 'Freelancer ' . auth()->user()->name . ' uploaded new attachment(s) for Invoice #' . $invoice->invoice_number;
        $newComment->addLog($invoice->client_id, 'invoice', $invoice->id, 'log', 'New Attachment Uploaded', $message,User::class);

        return response()->json(['success' => true]);
    }

    public function listAttachments(Invoice $invoice)
    {
        $attachments = $invoice->attachments()->latest()->get();

        $html = view('freelancer.partials.invoice.invoice_attachments_list', compact('attachments'))->render();
        return response()->json(['html' => $html]);
    }
}
