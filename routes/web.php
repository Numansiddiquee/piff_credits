<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\QuoteController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\VerificationRequestController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\Auth\GoogleController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->hasRole('Super Admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('Client')) {
        return redirect()->route('client.dashboard');
    } elseif ($user->hasRole('Freelancer')) {
        return redirect()->route('freelancer.dashboard');
    }

    abort(403, 'Unauthorized access');
})->middleware(['auth', 'verified', '2fa'])->name('dashboard');

Route::middleware(['auth', 'role:Super Admin','2fa'])->group(function () {

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/items', [AdminDashboardController::class, 'items'])->name('items');
        Route::get('/quotes', [AdminDashboardController::class, 'quotes'])->name('quotes');
        Route::get('/invoices', [AdminDashboardController::class, 'invoices'])->name('invoices');
        Route::get('/payments', [AdminDashboardController::class, 'payments'])->name('payments');
        Route::get('/users', [AdminDashboardController::class, 'users'])->name('users');
        Route::get('/verification-requests', [AdminDashboardController::class, 'verificationRequest'])->name('verification');


        Route::get('/transaction-history', [AdminDashboardController::class, 'transactionHistory'])->name('transaction-history');
        Route::get('/support', [AdminDashboardController::class, 'support'])->name('support');

        Route::prefix('user')->name('user.')->group(function () {
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::get('/view/{id}', [UserController::class, 'view'])->name('view');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
            Route::post('/update', [UserController::class, 'update'])->name('update');
        });

        Route::group(['prefix' => '/quote', 'as' => 'quote.'],function (){
            Route::get('/view/{id?}',[QuoteController::class,'view'])->name('view');
        });

        Route::group(['prefix' => '/invoice', 'as' => 'invoice.'],function (){
            Route::get('/view/{id?}',[InvoiceController::class,'view'])->name('view');
        });

        Route::group(['prefix' => 'item', 'as' => 'item.'], function () {
            Route::get('/create', [ItemController::class, 'create'])->name('create');
            Route::post('/store', [ItemController::class, 'store'])->name('store');
            Route::get('/edit/{item}', [ItemController::class, 'edit'])->name('edit');
            Route::post('/update', [ItemController::class, 'update'])->name('update');
            Route::get('/detail/{item}', [ItemController::class, 'show'])->name('show');
            Route::post('/detail/render', [ItemController::class, 'render'])->name('render');
            Route::post('/getItemData', [ItemController::class, 'getItemData'])->name('getItemData');
        });

        Route::prefix('/verification-requests/')->name('verification.')->group(function () {
            Route::get('{id}/documents', [VerificationRequestController::class, 'showDocuments'])->name('show');
            Route::post('{id}/approve', [VerificationRequestController::class, 'approve'])->name('approve');
            Route::post('{id}/reject', [VerificationRequestController::class, 'reject'])->name('reject');
        });

    });


    
    Route::group(['prefix' => 'company', 'as' => 'admin.company.profile.'], function () {
        Route::get('/profile', [AdminSettingController::class, 'view'])->name('view');
        Route::get('/setting', [AdminSettingController::class, 'setting'])->name('setting');
        Route::get('platform/setting', [AdminSettingController::class, 'platformSetting'])->name('platform.setting');
        Route::post('platform/setting/update', [AdminSettingController::class, 'platformSettingUpdate'])->name('platform.setting.update');
        Route::post('/profile/update', [AdminSettingController::class, 'update'])->name('update');
        Route::get('/security', [AdminSettingController::class, 'security'])->name('security');
        Route::post('/password/change', [AdminSettingController::class, 'changePassword'])->name('password.change');
        Route::get('/payment-method', [AdminSettingController::class, 'paymentMethod'])->name('payment.method');
        Route::post('/payment-method/credentials', [AdminSettingController::class, 'StoreCredentials'])->name('payment.credentials');

    });

});

Route::get('/verify-2fa', [TwoFactorController::class, 'index'])->name('verify.2fa');
Route::post('/verify-2fa', [TwoFactorController::class, 'store'])->name('verify.2fa.post');
Route::get('/resend-2fa', [TwoFactorController::class, 'resend'])->name('resend.2fa');

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
// Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::get('login/google/callback', [GoogleController::class, 'handleGoogleCallback']);// web.php
Route::get('/choose-role', [GoogleController::class, 'chooseRole'])->name('choose.role');
Route::post('/set-role', [GoogleController::class, 'setRole'])->name('set.role');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/freelancer.php';
require __DIR__.'/client.php';