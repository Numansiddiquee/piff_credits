<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Freelancer\DashboardController;
use App\Http\Controllers\Freelancer\ItemController;
use App\Http\Controllers\Freelancer\QuoteController;
use App\Http\Controllers\Freelancer\InvoiceController;
use App\Http\Controllers\Freelancer\SettingController;
use App\Http\Controllers\Freelancer\VerificationRequestController;


Route::middleware(['auth', 'role:Freelancer','2fa'])->group(function () {
    Route::get('/freelancer/dashboard', [DashboardController::class, 'index'])->name('freelancer.dashboard');

    Route::prefix('freelancer')->name('freelancer.')->group(function () {
        Route::get('/items', [DashboardController::class, 'items'])->name('items');
        Route::get('/quotes', [DashboardController::class, 'quotes'])->name('quotes');
        Route::get('/invoices', [DashboardController::class, 'invoices'])->name('invoices');
        Route::get('/payments', [DashboardController::class, 'payments'])->name('payments');
        Route::get('/kyc', [DashboardController::class, 'kyc'])->name('kyc');
        Route::get('/balance', [DashboardController::class, 'balance'])->name('balance');
        Route::get('/transactions', [DashboardController::class, 'transactions'])->name('transactions');
        Route::get('/transaction-history', [DashboardController::class, 'transactionHistory'])->name('transaction-history');
        Route::get('/reports', [DashboardController::class, 'reports'])->name('reports');
        Route::get('/accounting', [DashboardController::class, 'accounting'])->name('accounting');
        Route::get('/clients', [DashboardController::class, 'clients'])->name('clients');
        Route::get('/support', [DashboardController::class, 'support'])->name('support');
    });


    Route::group(['prefix' => 'item', 'as' => 'freelancer.item.'], function () {
        Route::get('/create', [ItemController::class, 'create'])->name('create');
        Route::post('/store', [ItemController::class, 'store'])->name('store');
        Route::get('/edit/{item}', [ItemController::class, 'edit'])->name('edit');
        Route::post('/update', [ItemController::class, 'update'])->name('update');
        Route::get('/detail/{item}', [ItemController::class, 'show'])->name('show');
        Route::post('/detail/render', [ItemController::class, 'render'])->name('render');
        Route::post('/getItemData', [ItemController::class, 'getItemData'])->name('getItemData');
    });

    Route::group(['prefix' => 'quote', 'as' => 'freelancer.quote.'], function () {
        Route::get('/new_quote', [QuoteController::class, 'new_quote'])->name('new_quote');
        Route::get('/edit_quote/{id}', [QuoteController::class, 'edit_quote'])->name('edit_quote');
        Route::get('/view_quote/{id}', [QuoteController::class, 'view_quote'])->name('view_quote');
        Route::post('/save_new_quote', [QuoteController::class, 'save_new_quote'])->name('save_new_quote');
        Route::post('/update_quote', [QuoteController::class, 'update_quote'])->name('update_quote');
        Route::post('/add_comment', [QuoteController::class, 'add_comment'])->name('add_comment');
        Route::post('/detail/render', [QuoteController::class, 'render'])->name('render');
        Route::get('/download/pdf/{id}', [QuoteController::class, 'generatePDF'])->name('generatePDF');

        Route::post('/getCustomerProjectsAndContacts', [QuoteController::class, 'getCustomerProjectsAndContacts'])->name('getCustomerProjectsAndContacts');
        
        Route::post('/quote_number_settings', [QuoteController::class, 'updateSettings'])->name('quote_number_settings');
        Route::post('/attachments/upload', [QuoteController::class, 'uploadInvoiceAttachment'])->name('attachments.upload');
        Route::get('/{quote}/attachments/list', [QuoteController::class, 'listAttachments'])->name('attachments.list');
        Route::get('/convert_to_invoice/{quote_id}', [QuoteController::class, 'convert_to_invoice'])->name('convert_to_invoice');
        Route::post('/send-email', [QuoteController::class, 'sendEmail'])->name('send.email');
    });

    Route::group(['prefix' => 'invoice', 'as' => 'freelancer.invoice.'], function () {
        Route::get('/create', [InvoiceController::class, 'create'])->name('create');
        Route::post('/store', [InvoiceController::class, 'store'])->name('store');
        Route::get('/edit/{invoice}', [InvoiceController::class, 'edit'])->name('edit');
        Route::post('/update', [InvoiceController::class, 'update'])->name('update');
        Route::get('/detail/{invoice}', [InvoiceController::class, 'show'])->name('show');
        Route::post('/detail/render', [InvoiceController::class, 'render'])->name('render');

        Route::get('create/client',[InvoiceController::class,'createClient'])->name('create_client');
        Route::post('store/client',[InvoiceController::class,'storeClient'])->name('store_client');

        Route::post('/invoice-number-settings', [InvoiceController::class, 'updateSettings'])->name('invoice_number_settings');
        Route::get('/clone/{invoice}', [InvoiceController::class, 'clone'])->name('clone');
        Route::post('/stop-reminder', [InvoiceController::class, 'stopReminder'])->name('stopReminder');
        Route::post('/update-due-details', [InvoiceController::class, 'updateDueDetails'])->name('updateDueDetails');
        Route::get('/download/pdf/{id}', [InvoiceController::class, 'generatePDF'])->name('generatePDF');
        Route::post('/write-off', [InvoiceController::class, 'writeOff'])->name('writeOff');
        Route::post('/add_comment', [InvoiceController::class, 'add_comment'])->name('add_comment');
        Route::post('/send-email', [InvoiceController::class, 'sendEmail'])->name('send.email');
        Route::post('/upload-file/email', [InvoiceController::class, 'uploadAttachment'])->name('upload.attachment');
        Route::post('/attachments/upload', [InvoiceController::class, 'uploadInvoiceAttachment'])->name('attachments.upload');
        Route::get('/{invoice}/attachments/list', [InvoiceController::class, 'listAttachments'])->name('attachments.list');
    });



    // For later use
    Route::group(['prefix' => 'payments_received', 'as' => 'freelancer.payments_received.'], function () {
        Route::get('/create/{customer_id?}', [PaymentReceivedController::class, 'create'])->name('create');
        Route::post('/save_new_payment', [PaymentReceivedController::class, 'save_new_payment'])->name('save_new_payment');
        Route::post('/customer_data', [PaymentReceivedController::class, 'customer_data'])->name('customer_data');
        Route::get('/view_payments/{id}', [PaymentReceivedController::class, 'view_payments'])->name('view_payments');
        Route::post('/render', [PaymentReceivedController::class, 'render'])->name('render');
        Route::get('/edit_payment/{id}', [PaymentReceivedController::class, 'edit_payment'])->name('edit_payment');
        Route::post('/update_payment', [PaymentReceivedController::class, 'update_payment'])->name('update_payment');
        Route::post('/payment_number_settings', [PaymentReceivedController::class, 'updateSettings'])->name('payment_number_settings');
        Route::post('/add_payment_mode', [PaymentReceivedController::class, 'add_payment_mode'])->name('add_payment_mode');


    });

    Route::group(['prefix' => 'freelancer/', 'as' => 'freelancer.profile.'], function () {
        Route::get('/profile', [SettingController::class, 'view'])->name('view');
        Route::get('/setting', [SettingController::class, 'setting'])->name('setting');
        Route::get('platform/setting', [SettingController::class, 'platformSetting'])->name('platform.setting');
        Route::post('platform/setting/update', [SettingController::class, 'platformSettingUpdate'])->name('platform.setting.update');
        Route::post('/profile/update', [SettingController::class, 'update'])->name('update');
        Route::get('/security', [SettingController::class, 'security'])->name('security');
        Route::post('/password/change', [SettingController::class, 'changePassword'])->name('password.change');
        Route::get('/payment-method', [SettingController::class, 'paymentMethod'])->name('payment.method');
        Route::post('/payment-method/credentials', [SettingController::class, 'StoreCredentials'])->name('payment.credentials');

    });

    Route::group(['prefix' => 'freelancer/kyc', 'as' => 'freelancer.kyc.'], function () {
        Route::get('/submit/documents', [VerificationRequestController::class, 'submitDocuments'])->name('submit.documents');

        // Route::post('/upload', [VerificationRequestController::class, 'upload'])->name('upload');
        
        Route::get('/kyc/token', [VerificationRequestController::class, 'getToken'])->name('token');

        Route::get('/access-token', [VerificationRequestController::class, 'getAccessToken'])->name('access-token');
    });

});
