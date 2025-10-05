<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Client\DashboardController;
use App\Http\Controllers\Client\SettingController;
use App\Http\Controllers\Client\VerificationRequestController;


Route::middleware(['auth', 'role:Client','2fa'])->group(function () {
    Route::get('/client/dashboard', [DashboardController::class, 'index'])->name('client.dashboard');


    Route::prefix('client')->name('client.')->group(function () {
        Route::get('/items', [DashboardController::class, 'items'])->name('items');
        Route::get('/quotes', [DashboardController::class, 'quotes'])->name('quotes');
        Route::get('/invoices', [DashboardController::class, 'invoices'])->name('invoices');
        Route::get('/payments', [DashboardController::class, 'payments'])->name('payments');

        Route::get('/kyb', [DashboardController::class, 'kyb'])->name('kyb');
        Route::get('/balance', [DashboardController::class, 'balance'])->name('balance');
        Route::get('/transactions', [DashboardController::class, 'transactions'])->name('transactions');
        Route::get('/transaction-history', [DashboardController::class, 'transactionHistory'])->name('transaction-history');
        Route::get('/accounting', [DashboardController::class, 'accounting'])->name('accounting');
        Route::get('/support', [DashboardController::class, 'support'])->name('support');
    });

    Route::group(['prefix' => 'client/company', 'as' => 'client.company.profile.'], function () {
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

    Route::group(['prefix' => 'client/kyb', 'as' => 'client.kyb.'], function () {
        Route::get('/submit/documents', [VerificationRequestController::class, 'submitDocuments'])->name('submit.documents');

        // Route::post('/upload', [VerificationRequestController::class, 'upload'])->name('upload');
        
        Route::get('/kyc/token', [VerificationRequestController::class, 'getToken'])->name('token');

        Route::get('/access-token', [VerificationRequestController::class, 'getAccessToken'])->name('access-token');
    });
});

